
##### 当前性能参数

- 变量设置

```
SET GLOBAL slow_query_log = ON
```

- 慢日志设置

```
SHOW VARIABLES LIKE "long%";
SHOW VARIABLES LIKE "slow%";

5.6版本的设置方式：
#开启慢查询 slow_query_log值为1或on表示开启，为0或off为关闭
slow_query_log=on 
#设置慢查询日志放在哪里
slow_query_log_file=mysql-slow 
#设置sql执行时间多长为慢查询
long_query_time=2
#表示没有使用索引的sql查询也会记录下来
log-queries-not-using-indexes

eg:
// 开启慢查询
SET GLOBAL slow_query_log = ON

// 插入30万条数据
INSERT INTO `b_log`(`remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent`) (SELECT `remote_addr`,`time_local`,`dateline`,`menthod`,`url`,`http_ver`,`status`,`body_bytes_sent`,`user_agent` FROM `b_log` WHERE `id` <= 300000)

// 耗时17s

// 日志记录在
slow_query_log_file d:\wamp\bin\mysql\mysql5.6.17\data\caokl-slow.log


```

> 自增

```
SHOW VARIABLES LIKE "auto_increment%";
```

> 自动

```
SHOW VARIABLES LIKE "auto%"
```

> 查看日志 - 所有日志，慢查询日志（slow_query_log），错误日志（log_error）

```
SHOW VARIABLES LIKE "%log%";
```

> 查看字符

```
SHOW VARIABLES LIKE "character%";
```
- 乱码问题本质：系统使用的字符集与连接的字符集不一致。
- 系统使用的字符集：表字符集 > 数据库字符集 > mysql字符集(latin1)
- 连接字符集设置: character_set_client、character_set_connection和character_set_results均为utf8；

> 查看连接

```
show variables like "%connect%"
```

> 查看innodb搜索引擎

```
show variables like "innodb%"
```

```
Variable_name	Value
auto_increment_increment	1
auto_increment_offset	1
autocommit	ON  // 自动提交，自动开启事务，也就是每一条sql,query都是一个事务
automatic_sp_privileges	ON
back_log	80 // back_log参数的值指出在MySQL暂时停止响应新请求之前的短时间内多少个请求可以被存在堆栈中
basedir	d:\\wamp\\bin\\mysql\\mysql5.6.17\\ //mysql安装目录
big_tables	OFF //   如果表大小超过tmp_table_size  那么启动磁盘表
bind_address	* // 增加远程访问IP地址或者禁掉这句话就可以让远程机登陆访问
binlog_cache_size	32768
binlog_checksum	CRC32
binlog_direct_non_transactional_updates	OFF
binlog_format	STATEMENT
binlog_max_flush_queue_time	0
binlog_order_commits	ON
binlog_row_image	FULL
binlog_rows_query_log_events	OFF
binlog_stmt_cache_size	32768
block_encryption_mode	aes-128-ecb
bulk_insert_buffer_size	8388608
character_set_client	utf8    // 客户端来源数据使用的字符集
character_set_connection	utf8    // 连接层字符集
character_set_database	utf8 // 当前选中数据库的默认字符集
character_set_filesystem	binary
character_set_results	utf8    // 查询结果字符集
character_set_server	latin1  // 默认的内部操作字符集
character_set_system	utf8    // 系统元数据(字段名等)字符集
character_sets_dir	d:\\wamp\\bin\\mysql\\mysql5.6.17\\share\\charsets\\
collation_connection	utf8_general_ci // 连接字符集的校对规则
collation_database	utf8_general_ci // 默认数据库使用的校对规则
collation_server	latin1_swedish_ci   // 服务器的默认校对规则
completion_type	NO_CHAIN
concurrent_insert	AUTO
connect_timeout	10  // 响应前等待连接包的秒数
core_file	OFF
datadir	d:\\wamp\\bin\\mysql\\mysql5.6.17\\data\\   // MySQL数据目录
date_format	%Y-%m-%d
datetime_format	%Y-%m-%d %H:%i:%s
default_storage_engine	InnoDB  // 默认存储引擎
default_tmp_storage_engine	InnoDB  // tmp默认存储引擎
default_week_format	0
delay_key_write	ON
delayed_insert_limit	100
delayed_insert_timeout	300
delayed_queue_size	1000
disconnect_on_expired_password	ON
div_precision_increment	4   // 操作符执行除操作的结果可增加的精确度的位数
end_markers_in_json	OFF
enforce_gtid_consistency	OFF
eq_range_index_dive_limit	10
error_count	0
event_scheduler	OFF
expire_logs_days	0
explicit_defaults_for_timestamp	ON
external_user	
flush	OFF
flush_time	0   // MySQL服务器会将所有打开的表每隔flush_time指定的时长进行关闭
foreign_key_checks	ON  // 是否为InnoDB表查检外键约束
ft_boolean_syntax	+ -><()~*:""&|
ft_max_word_len	84
ft_min_word_len	4
ft_query_expansion_limit	20
ft_stopword_file	(built-in)
general_log	OFF // 是否启用查询日志
general_log_file	d:\\wamp\\bin\\mysql\\mysql5.6.17\\data\\caokl.log  // 记录所有sql语句
group_concat_max_len	1024
gtid_executed	
gtid_mode	OFF
gtid_next	AUTOMATIC
gtid_owned	
gtid_purged	
have_compress	YES
have_crypt	NO  // crypt()系统调用是否可为MySQL服务器所用
have_dynamic_loading	YES
have_geometry	YES
have_openssl	DISABLED
have_profiling	YES // mysqld支持语句性能分析
have_query_cache	YES // mysqld支持查询缓存
have_rtree_keys	YES
have_ssl	DISABLED
have_symlink	YES
host_cache_size	279
hostname	caokl   // mysqld服务器启动时将主机名称赋值给此变量
identity	784542
ignore_builtin_innodb	OFF
ignore_db_dirs	
init_connect	// 设定在每个客户端与mysqld建立连接时事先执行的一个或多个(彼此间用分号隔开)SQL语句
init_file	// 定义在mysqld启动时使用的初始化文件，此文件每行包含一个单独的SQL语句
init_slave	
innodb_adaptive_flushing	ON  // 设定是否允许MySQL服务器根据工作负载动态调整刷写InnoDB buffer pool中的脏页的速率
innodb_adaptive_flushing_lwm	10
innodb_adaptive_hash_index	ON
innodb_adaptive_max_sleep_delay	150000
innodb_additional_mem_pool_size	8388608
innodb_api_bk_commit_interval	5
innodb_api_disable_rowlock	OFF
innodb_api_enable_binlog	OFF
innodb_api_enable_mdl	OFF
innodb_api_trx_level	0
innodb_autoextend_increment	64
innodb_autoinc_lock_mode	1
innodb_buffer_pool_dump_at_shutdown	OFF
innodb_buffer_pool_dump_now	OFF
innodb_buffer_pool_filename	ib_buffer_pool
innodb_buffer_pool_instances	8
innodb_buffer_pool_load_abort	OFF
innodb_buffer_pool_load_at_startup	OFF
innodb_buffer_pool_load_now	OFF
innodb_buffer_pool_size	134217728
innodb_change_buffer_max_size	25
innodb_change_buffering	all
innodb_checksum_algorithm	innodb
innodb_checksums	ON
innodb_cmp_per_index_enabled	OFF
innodb_commit_concurrency	0
innodb_compression_failure_threshold_pct	5
innodb_compression_level	6
innodb_compression_pad_pct_max	50
innodb_concurrency_tickets	5000
innodb_data_file_path	ibdata1:12M:autoextend
innodb_data_home_dir	
innodb_disable_sort_file_cache	OFF
innodb_doublewrite	ON
innodb_fast_shutdown	1
innodb_file_format	Antelope
innodb_file_format_check	ON
innodb_file_format_max	Antelope
innodb_file_per_table	ON
innodb_flush_log_at_timeout	1
innodb_flush_log_at_trx_commit	1
innodb_flush_method	
innodb_flush_neighbors	1
innodb_flushing_avg_loops	30
innodb_force_load_corrupted	OFF
innodb_force_recovery	0
innodb_ft_aux_table	
innodb_ft_cache_size	8000000
innodb_ft_enable_diag_print	OFF
innodb_ft_enable_stopword	ON
innodb_ft_max_token_size	84
innodb_ft_min_token_size	3
innodb_ft_num_word_optimize	2000
innodb_ft_result_cache_limit	2000000000
innodb_ft_server_stopword_table	
innodb_ft_sort_pll_degree	2
innodb_ft_total_cache_size	640000000
innodb_ft_user_stopword_table	
innodb_io_capacity	200
innodb_io_capacity_max	2000
innodb_large_prefix	OFF
innodb_lock_wait_timeout	50
innodb_locks_unsafe_for_binlog	OFF
innodb_log_buffer_size	8388608
innodb_log_compressed_pages	ON
innodb_log_file_size	50331648
innodb_log_files_in_group	2
innodb_log_group_home_dir	.\\
innodb_lru_scan_depth	1024
innodb_max_dirty_pages_pct	75
innodb_max_dirty_pages_pct_lwm	0
innodb_max_purge_lag	0
innodb_max_purge_lag_delay	0
innodb_mirrored_log_groups	1
innodb_monitor_disable	
innodb_monitor_enable	
innodb_monitor_reset	
innodb_monitor_reset_all	
innodb_old_blocks_pct	37
innodb_old_blocks_time	1000
innodb_online_alter_log_max_size	134217728
innodb_open_files	2000
innodb_optimize_fulltext_only	OFF
innodb_page_size	16384
innodb_print_all_deadlocks	OFF
innodb_purge_batch_size	300
innodb_purge_threads	1
innodb_random_read_ahead	OFF
innodb_read_ahead_threshold	56
innodb_read_io_threads	4
innodb_read_only	OFF
innodb_replication_delay	0
innodb_rollback_on_timeout	OFF
innodb_rollback_segments	128
innodb_sort_buffer_size	1048576
innodb_spin_wait_delay	6
innodb_stats_auto_recalc	ON
innodb_stats_method	nulls_equal
innodb_stats_on_metadata	OFF
innodb_stats_persistent	ON
innodb_stats_persistent_sample_pages	20
innodb_stats_sample_pages	8
innodb_stats_transient_sample_pages	8
innodb_status_output	OFF
innodb_status_output_locks	OFF
innodb_strict_mode	OFF
innodb_support_xa	ON
innodb_sync_array_size	1
innodb_sync_spin_loops	30
innodb_table_locks	ON
innodb_thread_concurrency	0
innodb_thread_sleep_delay	10000
innodb_undo_directory	.
innodb_undo_logs	128
innodb_undo_tablespaces	0
innodb_use_native_aio	ON
innodb_use_sys_malloc	ON
innodb_version	5.6.17
innodb_write_io_threads	4
insert_id	0   // AUTO_INCREMENT的字段执行INSERT或ALTER_TABLE语句时将使用此变量的值
interactive_timeout	28800   // mysqld进程等待一个已经建立连接的交互式客户端的后续命令之前所经过的秒数
join_buffer_size	262144
keep_files_on_create	OFF
key_buffer_size	8388608
key_cache_age_threshold	300
key_cache_block_size	1024
key_cache_division_limit	100
large_files_support	ON
large_page_size	0
large_pages	OFF // Linux平台上专用的参数，用于设定mysqld是否支持使用大内存页
last_insert_id	784542  // 此参数的值由LAST_INSERT_ID()函数返回
lc_messages	en_US
lc_messages_dir	d:\\wamp\\bin\\mysql\\mysql5.6.17\\share\\
lc_time_names	en_US
license	GPL
local_infile	ON
lock_wait_timeout	31536000    // 以秒为单位设定所有SQL语句等待获取元数据锁(metadata lock)的超时时长
log_bin	OFF // 是否启用二进制日志
log_bin_basename	
log_bin_index	
log_bin_trust_function_creators	OFF
log_bin_use_v1_row_events	OFF
log_error	d:\\wamp\\bin\\mysql\\mysql5.6.17\\data\\caokl.err  // 错误日志地址
log_output	FILE
log_queries_not_using_indexes	OFF
log_slave_updates	OFF
log_slow_admin_statements	OFF
log_slow_slave_statements	OFF
log_throttle_queries_not_using_indexes	0
log_warnings	1
long_query_time	10.000000
low_priority_updates	OFF
lower_case_file_system	ON
lower_case_table_names	1
master_info_repository	FILE
master_verify_checksum	OFF
max_allowed_packet	4194304
max_binlog_cache_size	18446744073709547520
max_binlog_size	1073741824
max_binlog_stmt_cache_size	18446744073709547520
max_connect_errors	100
max_connections	151 // 设定mysqld允许客户端同时发起的最大并发连接数
max_delayed_threads	20  // 设定为INSERT DELAYED语句所能够启动的最大线程数
max_error_count	64
max_heap_table_size	16777216
max_insert_delayed_threads	20
max_join_size	18446744073709551615
max_length_for_sort_data	1024
max_prepared_stmt_count	16382
max_relay_log_size	0
max_seeks_for_key	4294967295
max_sort_length	1024
max_sp_recursion_depth	0
max_tmp_tables	32
max_user_connections	0   // 设定单个用户允许同时向mysqld发起的最大并发连接请求个数
max_write_lock_count	4294967295  // mysqld已施加的写锁个数达到此参数值指定的个数时，将允许处理一些挂起的读请求
metadata_locks_cache_size	1024
metadata_locks_hash_instances	8
min_examined_row_limit	0
multi_range_count	256
myisam_data_pointer_size	6
myisam_max_sort_file_size	2146435072
myisam_mmap_size	18446744073709551615
myisam_recover_options	OFF
myisam_repair_threads	1
myisam_sort_buffer_size	8388608
myisam_stats_method	nulls_unequal
myisam_use_mmap	OFF
named_pipe	OFF
net_buffer_length	16384
net_read_timeout	30
net_retry_count	10
net_write_timeout	60
new	OFF
old	OFF
old_alter_table	OFF
old_passwords	0
open_files_limit	7048
optimizer_prune_level	1
optimizer_search_depth	62
optimizer_switch	index_merge=on,index_merge_union=on,index_merge_sort_union=on,index_merge_intersection=on,engine_condition_pushdown=on,index_condition_pushdown=on,mrr=on,mrr_cost_based=on,block_nested_loop=on,batched_key_access=off,materialization=on,semijoin=on,loosescan=on,firstmatch=on,subquery_materialization_cost_based=on,use_index_extensions=on
optimizer_trace	enabled=off,one_line=off
optimizer_trace_features	greedy_search=on,range_optimizer=on,dynamic_range=on,repeated_subselect=on
optimizer_trace_limit	1
optimizer_trace_max_mem_size	16384
optimizer_trace_offset	-1
performance_schema	ON
performance_schema_accounts_size	100
performance_schema_digests_size	10000
performance_schema_events_stages_history_long_size	10000
performance_schema_events_stages_history_size	10
performance_schema_events_statements_history_long_size	10000
performance_schema_events_statements_history_size	10
performance_schema_events_waits_history_long_size	10000
performance_schema_events_waits_history_size	10
performance_schema_hosts_size	100
performance_schema_max_cond_classes	80
performance_schema_max_cond_instances	3504
performance_schema_max_file_classes	50
performance_schema_max_file_handles	32768
performance_schema_max_file_instances	7693
performance_schema_max_mutex_classes	200
performance_schema_max_mutex_instances	15906
performance_schema_max_rwlock_classes	40
performance_schema_max_rwlock_instances	9102
performance_schema_max_socket_classes	10
performance_schema_max_socket_instances	322
performance_schema_max_stage_classes	150
performance_schema_max_statement_classes	168
performance_schema_max_table_handles	4000
performance_schema_max_table_instances	12500
performance_schema_max_thread_classes	50
performance_schema_max_thread_instances	402
performance_schema_session_connect_attrs_size	512
performance_schema_setup_actors_size	100
performance_schema_setup_objects_size	100
performance_schema_users_size	100
pid_file	d:\\wamp\\bin\\mysql\\mysql5.6.17\\data\\caokl.pid
plugin_dir	d:\\wamp\\bin\\mysql\\mysql5.6.17\\lib\\plugin\\
port	3306
preload_buffer_size	32768
profiling	OFF
profiling_history_size	15
protocol_version	10
proxy_user	
pseudo_slave_mode	OFF
pseudo_thread_id	47
query_alloc_block_size	8192
query_cache_limit	1048576
query_cache_min_res_unit	4096
query_cache_size	1048576
query_cache_type	OFF
query_cache_wlock_invalidate	OFF
query_prealloc_size	8192
rand_seed1	0
rand_seed2	0
range_alloc_block_size	4096
read_buffer_size	131072
read_only	OFF
read_rnd_buffer_size	262144
relay_log	
relay_log_basename	
relay_log_index	
relay_log_info_file	relay-log.info
relay_log_info_repository	FILE
relay_log_purge	ON
relay_log_recovery	OFF
relay_log_space_limit	0
report_host	
report_password	
report_port	3306
report_user	
rpl_stop_slave_timeout	31536000
secure_auth	ON
secure_file_priv	
server_id	0
server_id_bits	32
server_uuid	d570c327-8e6b-11e5-ae3a-e4f89ce2051c
shared_memory	OFF
shared_memory_base_name	MYSQL
skip_external_locking	ON
skip_name_resolve	OFF
skip_networking	OFF
skip_show_database	OFF
slave_allow_batching	OFF
slave_checkpoint_group	512
slave_checkpoint_period	300
slave_compressed_protocol	OFF
slave_exec_mode	STRICT
slave_load_tmpdir	C:\\windows\\TEMP
slave_max_allowed_packet	1073741824
slave_net_timeout	3600
slave_parallel_workers	0
slave_pending_jobs_size_max	16777216
slave_rows_search_algorithms	TABLE_SCAN,INDEX_SCAN
slave_skip_errors	OFF
slave_sql_verify_checksum	ON
slave_transaction_retries	10
slave_type_conversions	
slow_launch_time	2
slow_query_log	OFF
slow_query_log_file	d:\\wamp\\bin\\mysql\\mysql5.6.17\\data\\caokl-slow.log // 慢日志地址
socket	MySQL
sort_buffer_size	262144
sql_auto_is_null	OFF
sql_big_selects	ON
sql_buffer_result	OFF
sql_log_bin	ON
sql_log_off	OFF
sql_mode	NO_ENGINE_SUBSTITUTION
sql_notes	ON
sql_quote_show_create	ON
sql_safe_updates	OFF
sql_select_limit	18446744073709551615
sql_slave_skip_counter	0
sql_warnings	OFF
ssl_ca	
ssl_capath	
ssl_cert	
ssl_cipher	
ssl_crl	
ssl_crlpath	
ssl_key	
storage_engine	InnoDB
stored_program_cache	256
sync_binlog	0
sync_frm	ON
sync_master_info	10000
sync_relay_log	10000
sync_relay_log_info	10000
system_time_zone	
table_definition_cache	1400
table_open_cache	2000
table_open_cache_instances	1
thread_cache_size	9
thread_concurrency	10
thread_handling	one-thread-per-connection
thread_stack	262144
time_format	%H:%i:%s
time_zone	SYSTEM
timed_mutexes	OFF
timestamp	1473831921.233477
tmp_table_size	16777216
tmpdir	C:\\windows\\TEMP
transaction_alloc_block_size	8192
transaction_allow_batching	OFF
transaction_prealloc_size	4096
tx_isolation	REPEATABLE-READ
tx_read_only	OFF
unique_checks	ON
updatable_views_with_limit	YES
version	5.6.17
version_comment	MySQL Community Server (GPL)
version_compile_machine	x86_64
version_compile_os	Win64
wait_timeout	28800
warning_count	1
```

### percona-toolkit安装

#### 下载

```bash
$ docker pull 3laho3y3.mirror.aliyuncs.com/perconalab/percona-toolkit
```

#### 使用

```bash
docker run --user=root -v /var/log/mysql/mysql-slow.log:/mysql-slow.log --rm perconalab/percona-toolkit:latest pt-query-digest /mysql-slow.log >> pt/slow.log
```

