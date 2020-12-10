0、 在node1创建目录
$ mkdir /data/prometheus-data-pv
$ mkdir /data/grafana-data-pv

1、 依次执行
依次安装prometheus、granfa
```
# kubectl create -f prometheus-namespace.yaml  
# kubectl create -f prometheus-pv.yaml
# kubectl create -f prometheus-pvc.yaml
# kubectl create -f prometheus-node-exporter.yaml  
# kubectl create -f prometheus-deployment.yaml
# kubectl create -f grafana-pv.yaml
# kubectl create -f grafana-pvc.yaml  
# kubectl create -f grafana-deployment.yaml  
```

2、 配置grafana数据源
grafana默认账号:admin/admin
grafana目前登录账号：admin/shuqinkeji
把prometheus配置成数据源 ：http://prometheus-service.ns-monitor:9090                                                 

3、 导入一个Dashboard                                                                                                    
配置一个Dashboard, kubernetes-Pod-Resources.json内容导入

参考文章：https://www.jianshu.com/p/ac8853927528
由文章有过时之处，修改了较多处地方