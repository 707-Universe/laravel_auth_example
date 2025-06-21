# Laravel開発環境

これは開発者が簡単にLaravelの開発を開始できるようにするためのDocker化された開発環境です。

この開発環境は本番環境での使用を意図したものではなく、Laravelの開発に必要なすべてのツールが事前に設定されています。

Windows、Linux、MacOSで動作します。

# 設定方法

---

## 1. Hosts configuration

<a id="section_1"></a>

---

ローカル開発で使用するドメインは`laravel.test`です。

ドメインを利用するためには、OSのホストファイルまたはDNSサーバーを編集し、次の行を追加して、ローカル ドメイン名をシステムで使用できるようにする必要があります。

```
127.0.0.1 laravel.test
```

### 1.1. Windows

Windows上のhostsファイルは下記の場所にあります。

```
C:\Windows\system32\drivers\etc\hosts
```

管理者権限でメモ帳を起動し、「ファイル > 開く」からファイルを開き、情報を追加してファイルを保存する必要があります。

### 1.2. Linux/MacOS

LinuxおよびMac上のhostsファイルは下記の場所にあります。

```
/etc/hosts
```

お気に入りのエディターを使用して、sudo/rootとしてファイルを開き、情報を追加してファイルを保存する必要があります。

## 2. ファイルシステムの設定（Linux）

<a id="section_2"></a>

---

Linuxをご利用の場合は、 USRIDおよびGRPID環境変数が設定され、現在のセッションユーザーIDと一致していることを確認する必要があります。

これらの2つの変数は、Linux上でファイルシステムのパーミッションを正しく設定するために必要です。

次のように、起動する前に毎回1回実行できます。

```
export USRID=$(id -u) && export GRPID=$(id -g)
```

または、ターミナルで次のコマンドを実行して、これを .zshrc/.bashrc に追加することもできます。

```
grep -qxF 'export USRID=$(id -u) GRPID=$(id -g)' ~/.${SHELL##*/}rc || echo 'export USRID=$(id -u) GRPID=$(id -g)' >> ~/.${SHELL##*/}rc
```

`export`により、rcファイルに行が追加され、各ターミナルセッションで実行されます。

## 3. Laravelのプロジェクトを作成する

---

プロジェクトの作成フローを書く。

## 4. 開発ワークフロー

---

### 4.1. スピンアップ (起動)

開発環境を起動するには、次のようにdocker composeを実行します。

```
docker-compose -f .dev/docker-compose.yml up -d --build
```

**重要**: Linuxを使用しており、`export`によって、.zshrc/.bashrcファイルに行を追加していない場合は、[2. ファイルシステムの設定（Linux）](#section_2)の作業を行う必要があります。

そうしないと、権限の問題が発生します。

### 4.2. スピンダウン (停止)

環境を停止するには、次のように docker compose を実行します。

```
docker-compose -f .dev/docker-compose.yml down
```

### 4.3. バイナリの操作

このプロジェクト内の、composer、npm、artisan、pint、pestまたはその他のバイナリを正しく実行するには、次のようにコンテナにsshで接続する必要があります。

```
docker exec -it --user laravel laravel-dev-php /bin/bash
```

`/home/laravel/app` ディレクトリがアプリケーションのルートディレクトリなので、そこからコマンドを実行できます。

## 5. 含まれるもの

---

### 5.1. ウェブサーバー

このDocker化された環境では、PHP-FPMとNGINXを組み合わせてウェブサイトを提供しています。`laravel.test`

NGINXとPHP-FPMはどちらも開発環境に最適な設定になっています。本番環境では使用しないでください。

URL: http://laravel.test/

### 5.2. データベース

このDocker化された環境には、LaravelがサポートするデータベースのMySQLがサポートされています。

データベースに接続するための資格情報は次のとおりです。

| Key | Value |
| :---: | :---: |
| DB_USER | laravel |
| DB_PASS | laravel |
| DB_NAME | laravel |
| DB_HOST | db-mysql |
| DB_PORT | 3036 |

### 5.3. Adminer

Adminerは、データベースの内容を表示し、クエリを実行するためのUIツールです。

URL: http://laravel.test:8080

#### MySQL

MySQLにログインするには、上記のセクション(5.2. データベース)で指定されたパラメータを使用します。

### 5.4. Mailpit

Mailpitを利用するには、次の資格情報を使用します。

| Key | Value |
| :---: | :---: |
| MAIL DRIVER | smtp |
| MAIL HOST | mail |
| MAIL PORT | 1025 |
| MAIL ENCRYPTION | none |
| MAIL USER | *(空白)* |
| MAIL PASS | *(空白)* |
| FROM MAIL ADDR | *(自由)* |
| FROM MAIL NAME | *(自由)* |

URL: http://laravel.test:8025

