package fortest

import (
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"log"
	"math/rand"
	"strconv"
	"sync"
	"testing"
	"time"
	"unicode/utf8"
)

func init() {
	NewDbPool("formysqlWrite", &Dbconf{
		ip:          "127.0.0.1",
		port:        3306,
		database:    "formysql",
		user:        "root",
		pass:        "mariadb3306",
		maxLifetime: 0,
		maxOpen:     8,
		maxIdle:     4,
	})
}

func TestFind(t *testing.T) {
	db, err := GetDb("formysqlWrite")
	if err != nil {
		t.Errorf("%v", db)
	}
	simpledb := NewSimpledb(db)
	id := 1
	rowSlice, ferr := simpledb.Find("select * from formysql.`post_1` where id > ?", []interface{}{id}...)
	if ferr != nil {
		t.Errorf("%v", ferr)
	}
	for k, v := range rowSlice {
		t.Logf("%v => %v", k, v)
	}
}

func TestFindOne(t *testing.T) {
	db, err := GetDb("formysqlWrite")
	if err != nil {
		t.Errorf("%v", db)
	}
	simpledb := NewSimpledb(db)

	id := 2
	row, err := simpledb.FindOne("select * from formysql.`post_1` where id = ? limit 1", []interface{}{id}...)
	if err != nil {
		t.Errorf("%v", err)
	}
	t.Logf("%v", row)
}

func TestInsert(t *testing.T) {
	db, err := GetDb("formysqlWrite")
	if err != nil {
		t.Errorf("%v", db)
	}
	simpledb := NewSimpledb(db)
	id, err := simpledb.Insert("insert into formysql.`id_gen`(`id`) values(null)", nil...)
	if err != nil {
		t.Errorf("%v", err)
	}
	userid := genuserid()
	title := "二进制日志总结" + strconv.Itoa(userid)
	content := title + "###" + "MySQL的二进制日志（binary log）是一个二进制文件，主要用于记录修改数据或有可能引起数据变更的MySQL语句。二进制日志（binary log）中记录了对MySQL数据库执行更改的所有操作，并且记录了语句发生时间、执行时长、操作数据等其它额外信息，但是它不记录SELECT、SHOW等那些不修改数据的SQL语句。二进制日志（binary log）主要用于数据库恢复和主从复制，以及审计（audit）操作。"
	ctime := time.Now().Unix()
	_, ierr := simpledb.Insert("insert into formysql.`post_1`(`id`, `userid`, `title`, `content`, `ctime`)values(?, ?, ?, ?, ?)", []interface{}{id, userid, title, content, ctime}...)
	if ierr != nil {
		t.Errorf("%v", ierr)
	}
}

func TestUpdate(t *testing.T) {
	db, err := GetDb("formysqlWrite")
	if err != nil {
		t.Errorf("%v", db)
	}
	simpledb := NewSimpledb(db)
	content := "MySQL的二进制日志（binary log）是一个二进制文件"
	id := 1
	_, uerr := simpledb.Update("update formysql.`post_1` set `content` = ? where id = ?", []interface{}{content, id}...)
	if uerr != nil {
		t.Errorf("%v", uerr)
	}
}

func TestDelete(t *testing.T) {
	db, err := GetDb("formysqlWrite")
	if err != nil {
		t.Errorf("%v", db)
	}
	simpledb := NewSimpledb(db)
	id := 1
	_, uerr := simpledb.Update("delete from formysql.`post_1` where id = ?", []interface{}{id}...)
	if uerr != nil {
		t.Errorf("%v", uerr)
	}
}

func genuserid() int {
	rand.Seed(time.Now().UnixNano())
	return rand.Intn(2147483647)
}

func TestQuickInsert(t *testing.T) {
	rnum := 10
	wg := sync.WaitGroup{}
	wg.Add(rnum)
	for i := 1; i < rnum; i++ {
		go func() {
			sString := spilteRune("MySQL的二进制日志是一个二进制文件，主要用于记录修改数据或有可能引起数据变更的MySQL语句。二进制日志（binary log）中记录了对MySQL数据库执行更改的所有操作，并且记录了语句发生时间、执行时长、操作数据等其它额外信息，但是它不记录SELECT、SHOW等那些不修改数据的SQL语句。二进制日志（binary log）主要用于数据库恢复和主从复制，以及审计（audit）操作。", 10)
			for j := 1; j <= 100; j++ {
				db, err := GetDb("formysqlWrite")

				if err != nil {
					t.Errorf("%v", db)
				}
				simpledb := NewSimpledb(db)
				id, ierr := simpledb.Insert("insert into formysql.`id_gen`(`id`) values(null)", nil...)
				fmt.Print(ierr)
				if err != nil {
					fmt.Print(err)
					log.Println(err)
					t.Errorf("%v", err)
				}
				userid := genuserid()

				slen := len(sString)
				rand.Seed(time.Now().UnixNano())
				k := rand.Intn(slen)
				title := sString[k]
				nk := rand.Intn(slen)
				content := title + "###" + sString[nk]
				ctime := time.Now().Unix()
				_, tierr := simpledb.Insert("insert into formysql.`post_1`(`id`, `userid`, `title`, `content`, `ctime`)values(?, ?, ?, ?, ?)", []interface{}{id, userid, title, content, ctime}...)
				if ierr != nil {
					t.Errorf("%v", tierr)
				}
			}
			wg.Done()
		}()
	}

	wg.Wait()
}

func spilteRune(text string, length int) []string {
	rSlice := []rune(text)
	c := utf8.RuneCountInString(text)
	if c <= length {
		return []string{text}
	}
	var sString []string
	for i := 0; i <= c; i += length {
		if i+length > c {
			sString = append(sString, string(rSlice[i:]))
		} else {
			sString = append(sString, string(rSlice[i:i+length]))
		}
	}
	return sString
}

func TestAutoCreateTable(t *testing.T) {
	tablename := "post_2"
	createTableSql := `CREATE TABLE ` + tablename + ` (
		id bigint(11) unsigned NOT NULL,
		userid int(10) NOT NULL DEFAULT 0 COMMENT 'userid',
		title varchar(255) NOT NULL DEFAULT '',
		content varchar(255) NOT NULL COMMENT 'content',
		ctime int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
		PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;`
	db, err := GetDb("formysqlWrite")

	if err != nil {
		t.Errorf("%v", db)
	}
	db.Exec(createTableSql)

}
