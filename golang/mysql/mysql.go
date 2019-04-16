package fortest

import (
	"database/sql"
	"errors"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"time"
)

var defaultDb *Dbpool

func init() {
	defaultDb = new(Dbpool)
	defaultDb.db = make(map[string]*sql.DB)
	defaultDb.conf = make(map[string]*Dbconf)
}

func NewDbPool(poolname string, dbconf *Dbconf) error {
	db, err := sql.Open("mysql", dbconf.Dsn())
	if err != nil {
		return err
	}
	db.SetConnMaxLifetime(dbconf.maxLifetime)
	db.SetMaxIdleConns(dbconf.maxIdle)
	db.SetMaxOpenConns(dbconf.maxOpen)
	defaultDb.setDb(poolname, db)
	defaultDb.setConf(poolname, dbconf)
	return nil
}

func GetDb(poolname string) (*sql.DB, error) {
	if db, ok := defaultDb.db[poolname]; ok {
		return db, nil
	} else {
		return nil, errors.New("not exist")
	}
}

type Dbconf struct {
	ip          string
	port        int
	database    string
	user        string
	pass        string
	maxOpen     int           //设置最大打开的连接数，默认值为0表示不限制
	maxIdle     int           // 用于设置闲置的连接数
	maxLifetime time.Duration ////连接最长存活期，超过这个时间连接将不再被复用 0表示不限制
}

func (c *Dbconf) Dsn() string {
	return fmt.Sprintf("%s:%s@tcp(%s:%d)/%s?charset=utf8", c.user, c.pass, c.ip, c.port, c.database)
}

type Dbpool struct {
	db   map[string]*sql.DB
	conf map[string]*Dbconf
}

func (d *Dbpool) setDb(poolname string, db *sql.DB) {
	d.db[poolname] = db
}

func (d *Dbpool) setConf(poolname string, c *Dbconf) {
	d.conf[poolname] = c
}

type simpledb struct {
	db *sql.DB
}

func NewSimpledb(db *sql.DB) *simpledb {
	return &simpledb{
		db: db,
	}
}

func (s *simpledb) Insert(sql string, args ...interface{}) (int64, error) {
	if result, err := s.execSql(sql, args...); err == nil {
		return result.LastInsertId()
	} else {
		return 0, err
	}

}

func (s *simpledb) Update(sql string, args ...interface{}) (int64, error) {
	if result, err := s.execSql(sql, args...); err != nil {
		return result.RowsAffected()
	} else {
		return 0, err
	}
}

func (s *simpledb) Delete(sql string, args ...interface{}) (int64, error) {
	if result, err := s.execSql(sql, args...); err != nil {
		return result.RowsAffected()
	} else {
		return 0, err
	}
}

func (s *simpledb) execSql(sql string, args ...interface{}) (sql.Result, error) {
	stmt, err := s.db.Prepare(sql)
	if err != nil {
		return nil, err
	}
	return stmt.Exec(args...)
}

func (s *simpledb) FindOne(sql string, args ...interface{}) (map[string]string, error) {
	stmt, err := s.db.Prepare(sql)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(args...)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	cols, err := rows.Columns()

	vals := make([][]byte, len(cols))
	scans := make([]interface{}, len(cols))
	for k, _ := range vals {
		scans[k] = &vals[k]
	}

	for rows.Next() {
		rows.Scan(scans...)
		rowm := make(map[string]string, len(cols))
		for k, v := range vals {
			if v == nil {
				rowm[cols[k]] = ""
			} else {
				rowm[cols[k]] = string(v)
			}
		}
		return rowm, nil
	}
	return nil, errors.New("not exist")
}

func (s *simpledb) Find(sql string, args ...interface{}) ([]map[string]string, error) {
	stmt, err := s.db.Prepare(sql)
	if err != nil {
		return nil, err
	}
	defer stmt.Close()
	rows, err := stmt.Query(args...)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	cols, err := rows.Columns()

	vals := make([][]byte, len(cols))
	scans := make([]interface{}, len(cols))
	for k, _ := range vals {
		scans[k] = &vals[k]
	}

	rowmSlice := []map[string]string{}
	for rows.Next() {
		rows.Scan(scans...)
		rowm := make(map[string]string, len(cols))
		for k, v := range vals {
			if v == nil {
				rowm[cols[k]] = ""
			} else {
				rowm[cols[k]] = string(v)
			}
		}
		rowmSlice = append(rowmSlice, rowm)
	}
	return rowmSlice, nil
}
