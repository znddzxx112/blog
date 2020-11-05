

[TOC]



### kubernetes

> https://github.com/kubernetes/kubernetes

源码分析：http://qiankunli.github.io/2018/12/31/kubernetes_source_kubelet.html



### minikube搭建单机k8s

#### docker镜像源

```bash
cat /etc/docker/daemon.json 
{
	  "registry-mirrors": ["https://docker.mirrors.ustc.edu.cn"]
}

```



#### kubectl命令安装

可以从kubernetes库上直接下载，方法如下：

step 1: 访问官方github网址：https://github.com/kubernetes/kubernetes/releases

step 2: 找到想使用的发布版本，在每个发布版本的最后一行有类似“CHANGELOG-1.10.md”这样的内容，点击超链进入；

step 3: 然后进入“Client Binaries”区域；

step 4: 选择和目标机器系统匹配的二进制包下载；

step 5: 解压缩，放入/usr/local/bin目录；

https://github.com/kubernetes/kubernetes/releases



#### minikube安装

https://github.com/kubernetes/minikube/releases/tag/v1.14.1

##### 使用非root用户但在docker组成员启动minikube：

```bash
$ minikube start --cpus=2 --memory=2048mb --driver=docker --registry-mirror=https://registry.docker-cn.com
```

##### minikube 关闭

```bash
$ minikube stop
```



### k8s搭建过程

##### 1、关闭swap内存，注释文件/etc/fstab文件第二行，重启

```
vi /etc/fstab
```



##### 2、安装docker并修改docker配置（安装步骤省略）

```
vi /etc/docker/daemon.json
```

```
{
  "registry-mirrors": [
    "https://dockerhub.azk8s.cn",
    "https://reg-mirror.qiniu.com",
    "https://quay-mirror.qiniu.com"
  ],
  "exec-opts": [ "native.cgroupdriver=systemd" ]
}
```

```
sudo systemctl daemon-reload
sudo systemctl restart docker
```

##### 3、安装下载 k8s 的三个主要组件kubelet、kubeadm以及kubectl

##### (各节点都要安装)

```
# 使得 apt 支持 ssl 传输
apt-get update && apt-get install -y apt-transport-https
# 下载 gpg 密钥
curl https://mirrors.aliyun.com/kubernetes/apt/doc/apt-key.gpg | apt-key add - 
# 添加 k8s 镜像源
cat <<EOF >/etc/apt/sources.list.d/kubernetes.list
deb https://mirrors.aliyun.com/kubernetes/apt/ kubernetes-xenial main
EOF
# 更新源列表
apt-get update
# 下载 kubectl，kubeadm以及 kubelet
apt-get install -y kubelet kubeadm kubectl
```



##### 4、初始化master节点

将赋值给`--apiserver-advertise-address`参数的 ip 地址修改为自己的`master`主机地址

```
kubeadm init \
--apiserver-advertise-address=192.168.4.190 \
--image-repository registry.aliyuncs.com/google_containers \
--pod-network-cidr=10.244.0.0/16
```

当你看到如下字样是，就说明初始化成功了，**请把最后那行以`kubeadm join`开头的命令复制下来，之后安装工作节点时要用到的**，如果你不慎遗失了该命令，可以在`master`节点上使用`kubeadm token create --print-join-command`命令来重新生成一条。

```
Your Kubernetes control-plane has initialized successfully!

To start using your cluster, you need to run the following as a regular user:

  mkdir -p $HOME/.kube
  sudo cp -i /etc/kubernetes/admin.conf $HOME/.kube/config
  sudo chown $(id -u):$(id -g) $HOME/.kube/config

You should now deploy a pod network to the cluster.
Run "kubectl apply -f [podnetwork].yaml" with one of the options listed at:
  https://kubernetes.io/docs/concepts/cluster-administration/addons/

Then you can join any number of worker nodes by running the following on each as root:

kubeadm join 192.168.4.190:6443 --token 42dffa.2o0flyaqp1q4pzft \
    --discovery-token-ca-cert-hash sha256:56909d5c480543c3293ab513caebe35a069e07a3b59a200a6a4d56229fc68f55
```

配置 kubectl 工具

```
mkdir -p /root/.kube && \
cp /etc/kubernetes/admin.conf /root/.kube/config
```

执行完成后并不会刷新出什么信息，可以通过下面两条命令测试 `kubectl`是否可用：

```
# 查看已加入的节点
kubectl get nodes
# 查看集群状态
kubectl get cs
```

部署flannel网络

`flannel`是什么？它是一个专门为 k8s 设置的网络规划服务，可以让集群中的不同节点主机创建的 docker 容器都具有全集群唯一的虚拟IP地址。想要部署`flannel`的话直接执行下述命令即可：

```
kubectl apply -f https://raw.githubusercontent.com/coreos/flannel/a70459be0084506e4ec919aa1c114638878db11b/Documentation/kube-flannel.yml
```

部署失败，连接不上raw.githubusercontent.com

```
The connection to the server raw.githubusercontent.com was refused - did you specify the right host or port?
```

在/etc/hosts中添加一下内容

```
151.101.76.133 raw.githubusercontent.com
```

重新执行之后还是不行,换个链接执行

```
kubectl apply -f https://raw.githubusercontent.com/coreos/flannel/master/Documentation/kube-flannel.yml
```

成功之后运行

```
systemctl daemon-reload
```

再查看master节点是否处于ready状态，如果是则完成

```
kubectl get nodes
```

k8s管理节点完成

##### 5、将 slave 节点加入网络

执行之前让保存的

```
kubeadm join 192.168.4.190:6443 --token 42dffa.2o0flyaqp1q4pzft \
    --discovery-token-ca-cert-hash sha256:56909d5c480543c3293ab513caebe35a069e07a3b59a200a6a4d56229fc68f55
```

### kubernetes-dashboard

参考文章：
0、 https://kubernetes.io/zh/docs/tasks/access-application-cluster/web-ui-dashboard/
1、 https://www.cnblogs.com/RainingNight/p/deploying-k8s-dashboard-ui.html
2、 https://github.com/kubernetes/dashboard/blob/master/docs/user/access-control/creating-sample-user.md

#### 安装dashboard

下载kubernetes-dashboard.yaml
https://raw.githubusercontent.com/kubernetes/dashboard/v2.0.0/aio/deploy/recommended.yaml

防止镜像重复拉取，对文件做修改：containers下修改了imagePullPolicy: IfNotPresent

```yaml
# Copyright 2017 The Kubernetes Authors.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

apiVersion: v1
kind: Namespace
metadata:
  name: kubernetes-dashboard

---

apiVersion: v1
kind: ServiceAccount
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
  namespace: kubernetes-dashboard

---

kind: Service
apiVersion: v1
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
  namespace: kubernetes-dashboard
spec:
  ports:
    - port: 443
      targetPort: 8443
  selector:
    k8s-app: kubernetes-dashboard

---

apiVersion: v1
kind: Secret
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard-certs
  namespace: kubernetes-dashboard
type: Opaque

---

apiVersion: v1
kind: Secret
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard-csrf
  namespace: kubernetes-dashboard
type: Opaque
data:
  csrf: ""

---

apiVersion: v1
kind: Secret
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard-key-holder
  namespace: kubernetes-dashboard
type: Opaque

---

kind: ConfigMap
apiVersion: v1
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard-settings
  namespace: kubernetes-dashboard

---

kind: Role
apiVersion: rbac.authorization.k8s.io/v1
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
  namespace: kubernetes-dashboard
rules:
  # Allow Dashboard to get, update and delete Dashboard exclusive secrets.
  - apiGroups: [""]
    resources: ["secrets"]
    resourceNames: ["kubernetes-dashboard-key-holder", "kubernetes-dashboard-certs", "kubernetes-dashboard-csrf"]
    verbs: ["get", "update", "delete"]
    # Allow Dashboard to get and update 'kubernetes-dashboard-settings' config map.
  - apiGroups: [""]
    resources: ["configmaps"]
    resourceNames: ["kubernetes-dashboard-settings"]
    verbs: ["get", "update"]
    # Allow Dashboard to get metrics.
  - apiGroups: [""]
    resources: ["services"]
    resourceNames: ["heapster", "dashboard-metrics-scraper"]
    verbs: ["proxy"]
  - apiGroups: [""]
    resources: ["services/proxy"]
    resourceNames: ["heapster", "http:heapster:", "https:heapster:", "dashboard-metrics-scraper", "http:dashboard-metrics-scraper"]
    verbs: ["get"]

---

kind: ClusterRole
apiVersion: rbac.authorization.k8s.io/v1
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
rules:
  # Allow Metrics Scraper to get metrics from the Metrics server
  - apiGroups: ["metrics.k8s.io"]
    resources: ["pods", "nodes"]
    verbs: ["get", "list", "watch"]

---

apiVersion: rbac.authorization.k8s.io/v1
kind: RoleBinding
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
  namespace: kubernetes-dashboard
roleRef:
  apiGroup: rbac.authorization.k8s.io
  kind: Role
  name: kubernetes-dashboard
subjects:
  - kind: ServiceAccount
    name: kubernetes-dashboard
    namespace: kubernetes-dashboard

---

apiVersion: rbac.authorization.k8s.io/v1
kind: ClusterRoleBinding
metadata:
  name: kubernetes-dashboard
roleRef:
  apiGroup: rbac.authorization.k8s.io
  kind: ClusterRole
  name: kubernetes-dashboard
subjects:
  - kind: ServiceAccount
    name: kubernetes-dashboard
    namespace: kubernetes-dashboard

---

kind: Deployment
apiVersion: apps/v1
metadata:
  labels:
    k8s-app: kubernetes-dashboard
  name: kubernetes-dashboard
  namespace: kubernetes-dashboard
spec:
  replicas: 1
  revisionHistoryLimit: 10
  selector:
    matchLabels:
      k8s-app: kubernetes-dashboard
  template:
    metadata:
      labels:
        k8s-app: kubernetes-dashboard
    spec:
      containers:
        - name: kubernetes-dashboard
          image: kubernetesui/dashboard:v2.0.0
          imagePullPolicy: IfNotPresent
          ports:
            - containerPort: 8443
              protocol: TCP
          args:
            - --auto-generate-certificates
            - --namespace=kubernetes-dashboard
            # Uncomment the following line to manually specify Kubernetes API server Host
            # If not specified, Dashboard will attempt to auto discover the API server and connect
            # to it. Uncomment only if the default does not work.
            # - --apiserver-host=http://my-address:port
          volumeMounts:
            - name: kubernetes-dashboard-certs
              mountPath: /certs
              # Create on-disk volume to store exec logs
            - mountPath: /tmp
              name: tmp-volume
          livenessProbe:
            httpGet:
              scheme: HTTPS
              path: /
              port: 8443
            initialDelaySeconds: 30
            timeoutSeconds: 30
          securityContext:
            allowPrivilegeEscalation: false
            readOnlyRootFilesystem: true
            runAsUser: 1001
            runAsGroup: 2001
      volumes:
        - name: kubernetes-dashboard-certs
          secret:
            secretName: kubernetes-dashboard-certs
        - name: tmp-volume
          emptyDir: {}
      serviceAccountName: kubernetes-dashboard
      nodeSelector:
        "kubernetes.io/os": linux
      # Comment the following tolerations if Dashboard must not be deployed on master
      tolerations:
        - key: node-role.kubernetes.io/master
          effect: NoSchedule

---

kind: Service
apiVersion: v1
metadata:
  labels:
    k8s-app: dashboard-metrics-scraper
  name: dashboard-metrics-scraper
  namespace: kubernetes-dashboard
spec:
  ports:
    - port: 8000
      targetPort: 8000
  selector:
    k8s-app: dashboard-metrics-scraper

---

kind: Deployment
apiVersion: apps/v1
metadata:
  labels:
    k8s-app: dashboard-metrics-scraper
  name: dashboard-metrics-scraper
  namespace: kubernetes-dashboard
spec:
  replicas: 1
  revisionHistoryLimit: 10
  selector:
    matchLabels:
      k8s-app: dashboard-metrics-scraper
  template:
    metadata:
      labels:
        k8s-app: dashboard-metrics-scraper
      annotations:
        seccomp.security.alpha.kubernetes.io/pod: 'runtime/default'
    spec:
      containers:
        - name: dashboard-metrics-scraper
          image: kubernetesui/metrics-scraper:v1.0.4
          imagePullPolicy: IfNotPresent
          ports:
            - containerPort: 8000
              protocol: TCP
          livenessProbe:
            httpGet:
              scheme: HTTP
              path: /
              port: 8000
            initialDelaySeconds: 30
            timeoutSeconds: 30
          volumeMounts:
          - mountPath: /tmp
            name: tmp-volume
          securityContext:
            allowPrivilegeEscalation: false
            readOnlyRootFilesystem: true
            runAsUser: 1001
            runAsGroup: 2001
      serviceAccountName: kubernetes-dashboard
      nodeSelector:
        "kubernetes.io/os": linux
      # Comment the following tolerations if Dashboard must not be deployed on master
      tolerations:
        - key: node-role.kubernetes.io/master
          effect: NoSchedule
      volumes:
        - name: tmp-volume
          emptyDir: {}
```



docker pull kubernetesui/metrics-scraper:v1.0.4

docker pull kubernetesui/dashboard:v2.0.0

kubectl create -f kubernetes-dashboard.yaml

#### 访问dashboard

1、 生成p12
首先找到kubectl命令的配置文件，默认情况下为/etc/kubernetes/admin.conf，复制到了$HOME/.kube/config中。
然后我们使用client-certificate-data和client-key-data生成一个p12文件，可使用下列命令：

生成client-certificate-data

grep 'client-certificate-data' ~/.kube/config | head -n 1 | awk '{print $2}' | base64 -d >> kubecfg.crt

生成client-key-data

grep 'client-key-data' ~/.kube/config | head -n 1 | awk '{print $2}' | base64 -d >> kubecfg.key

1、生成p12

openssl pkcs12 -export -clcerts -inkey kubecfg.key -in kubecfg.crt -out kubecfg.p12 -name "kubernetes-client"

2、 导入证书
设置->安全->管理htpps/ssl证书和设置

3、 获取kubernetes-dashboard用户token

kubectl get secret --namespace=kubernetes-dashboard

kubectl describe secret kubernetes-dashboard-token-xtg7t -n kubernetes-dashboard

4、浏览器访问并填写token：https://[master-ip]:6443/api/v1/namespaces/kubernetes-dashboard/services/https:kubernetes-dashboard:/proxy/

5、 创建管理员用户

kubectl create -f k8s-admin-user.yaml

```
apiVersion: v1
kind: ServiceAccount
metadata:
  name: admin-user
  namespace: kubernetes-dashboard
---
apiVersion: rbac.authorization.k8s.io/v1
kind: ClusterRoleBinding
metadata:
  name: admin-user
roleRef:
  apiGroup: rbac.authorization.k8s.io
  kind: ClusterRole
  name: cluster-admin
subjects:
- kind: ServiceAccount
  name: admin-user
  namespace: kubernetes-dashboard
```

6. 获得管理员token

kubectl get secret -n kubernetes-dashboard

kubectl describe  secret admin-user-token-2cmj2 -n kubernetes-dashboard

或者

kubectl -n kubernetes-dashboard describe secret $(kubectl -n kubernetes-dashboard get secret | grep admin-user | awk '{print $1}')





### kubectl-debug

#### 安装kubectl-debug

```bash
export PLUGIN_VERSION=0.1.1
# linux x86_64
curl -Lo kubectl-debug.tar.gz https://github.com/aylei/kubectl-debug/releases/download/v${PLUGIN_VERSION}/kubectl-debug_${PLUGIN_VERSION}_linux_amd64.tar.gz
# macos
curl -Lo kubectl-debug.tar.gz https://github.com/aylei/kubectl-debug/releases/download/v${PLUGIN_VERSION}/kubectl-debug_${PLUGIN_VERSION}_darwin_amd64.tar.gz

tar -zxvf kubectl-debug.tar.gz kubectl-debug
sudo mv kubectl-debug /usr/local/bin/
```

#### 创建debug-agent的DaemonSet

kubectl create -f kubectl-debug-agent.yaml

kubectl-debug-agent.yaml

```yaml
apiVersion: apps/v1
kind: DaemonSet
metadata:
  labels:
    app: debug-agent
  name: debug-agent
spec:
  selector:
    matchLabels:
      app: debug-agent
  template:
    metadata:
      labels:
        app: debug-agent
    spec:
      hostPID: true
      tolerations:
        - key: node-role.kubernetes.io/master
          effect: NoSchedule
      containers:
        - name: debug-agent
          image: aylei/debug-agent:latest
          imagePullPolicy: Always
          securityContext:
            privileged: true
          livenessProbe:
            failureThreshold: 3
            httpGet:
              path: /healthz
              port: 10027
              scheme: HTTP
            initialDelaySeconds: 10
            periodSeconds: 10
            successThreshold: 1
            timeoutSeconds: 1
          ports:
            - containerPort: 10027
              hostPort: 10027
              name: http
              protocol: TCP
          volumeMounts:
            - name: cgroup
              mountPath: /sys/fs/cgroup
            - name: lxcfs
              mountPath: /var/lib/lxc
              mountPropagation: Bidirectional
            - name: docker
              mountPath: "/var/run/docker.sock"
            - name: runcontainerd
              mountPath: "/run/containerd"
            - name: runrunc
              mountPath: "/run/runc"
            - name: vardata
              mountPath: "/var/data"
      # hostNetwork: true
      volumes:
        - name: cgroup
          hostPath:
            path: /sys/fs/cgroup
        - name: lxcfs
          hostPath:
            path: /var/lib/lxc
            type: DirectoryOrCreate
        - name: docker
          hostPath:
            path: /var/run/docker.sock
        # containerd client will need to access /var/data, /run/containerd and /run/runc
        - name: vardata
          hostPath:
            path: /var/data
        - name: runcontainerd
          hostPath:
            path: /run/containerd
        - name: runrunc
          hostPath:
            path: /run/runc
  updateStrategy:
    rollingUpdate:
      maxUnavailable: 5
    type: RollingUpdate
```

#### 调试操作

```bash
$ kubectl-debug ${pod-name}
```





### 资源文件模板

#### 创建Pod

```yaml
apiVersion: v1
kind: Pod
metadata:
        name: nginx
        labels:
            app: nginx
            io.ckl: nginx
spec:
        containers:
                - name: io-ckl-nginx
                  image: nginx:latest
                  ports:
                         - containerPort: 80
                  imagePullPolicy: IfNotPresent
```



#### 创建Deployment

```
apiVersion: apps/v1
kind: Deployment
metadata:
        name: nginx-deployment
        labels:
            io.ckl: nginx-deployment
spec:
        replicas: 3
        selector:
            matchLabels:
              app: nginx
              io.ckl: nginx        
        template:
            metadata:
              labels:
                 app: nginx
                 io.ckl: nginx
            spec:
               containers:
                       - name: nginx
                         image: nginx:latest
                         imagePullPolicy: IfNotPresent
                         ports:
                                 - containerPort: 80
```



#### 创建Service-nodeport

```yaml
apiVersion: v1
kind: Service
metadata:
        name: nginx-service-nodeport
spec:
        selector:
                app: nginx
        ports:
               - name: http
                 port: 8080
                 targetPort: 80

        type: NodePort
```



#### 创建mysql服务-service、deployment、pv、pvc

```yaml
apiVersion: v1
kind: PersistentVolume
metadata:
  name: hto-common-mysql-pv
  labels:
    type: hto-common-mysql-pv
spec:
  capacity:
    storage: 1Gi
  volumeMode: Filesystem
  accessModes:
    - ReadWriteOnce
  persistentVolumeReclaimPolicy: Delete
  storageClassName: local-storage
  local:
    path: /home/znddzxx112/data/hto-common-mysql
  nodeAffinity:
    required:
      nodeSelectorTerms:
      - matchExpressions:
        - key: name
          operator: In
          values:
          - hto-common-mysql
----
apiVersion:  v1
kind: PersistentVolumeClaim
metadata: 
  name: hto-common-mysql-pvc
spec: 
  accessModes: 
    - ReadWriteOnce          
  resources: 
    requests: 
      storage: 200Mi   
---
apiVersion: apps/v1
kind: Deployment
metadata: 
  name: hto-common-mysql
spec: 
  selector: 
    matchLabels: 
      app: hto-common-mysql
  template: 
    metadata: 
      labels: 
        app: hto-common-mysql
    spec: 
      containers: 
      - name: hto-common-mysql 
        image: mysql:5.7
        imagePullPolicy: IfNotPresent
        env:           
        - name: MYSQL_ROOT_PASSWORD
          value: hto123
        ports: 
        - containerPort: 3306
        volumeMounts: 
        - name: mysql-persistent-storage
          mountPath: /var/lib/mysql                 
      volumes: 
      - name: mysql-persistent-storage
        persistentVolumeClaim: 
          claimName: hto-common-mysql-pvc           
---
apiVersion: v1
kind: Service
metadata: 
  name: hto-common-mysql-svc
spec: 
  type: NodePort
  ports: 
  - port: 3306
    targetPort: 3306
  selector: 
    app: hto-common-mysql
```

#### configmap

用于环境变量

```yaml
apiVersion: v1
kind: ConfigMap
metadata:
  name: hto-config-env
data:
  port: "7680"
  configPath: ./conf/config.yaml
```

用于配置文件

```yaml
apiVersion: v1
kind: ConfigMap
metadata:
  name: hto-config-file
data:
  config.yaml: |
    debug: true
    qqwry_path: ./conf/ip/qqwry.dat
    resource_init_submit: false
```



#### 部署busybox

使用环境变量和配置文件

```yaml
apiVersion: apps/v1
kind: Deployment
metadata: 
  name: hto-common-busybox
spec: 
  selector: 
    matchLabels: 
      app: hto-common-busybox
  template: 
    metadata: 
      labels: 
        app: hto-common-busybox
    spec: 
      containers: 
      - name: hto-common-busybox 
        image: busybox:latest
        imagePullPolicy: IfNotPresent
        command:
        - tail 
        - "-f" 
        - "/etc/hosts"
        envFrom:
            - configMapRef:
                name: hto-config-env
          volumeMounts:
            - name: hto-config-file
              mountPath: /app/conf
      volumes:
        - name: hto-config-file
          configMap:
            name: hto-config-file
            items:
              - key: config.yaml
                path: config.yaml
```

