# laravel_docker_example

---

## はじめに

このリポジトリはDockerを利用する事で、Laravelの開発環境を楽々と構築するために作成しました。

---

## 利用方法

### 1. Dockerコンテナを起動する

`.dev`ディレクトリには、Docker関連のデータが保存されている。

```
docker-compose -f .dev/docker-compose.yml up -d --build
```

上記のコマンドを実行する。

#### 1.1. Dockerコンテナを停止したい場合

```
docker compose -f .dev/docker-compose.yml down
```

上記のコマンドを実行する。

### 2. 開発環境のenvファイルを用意する

```
cat .env.development > .env
```

上記コマンドは、envファイルを新規作成します。

### 3. hostsを設定する

hostsを設定すると <http://laravel.test/> というURLでLaravelにアクセスできるようになります。

具体的な設定方法はにつきましては、別ページでまとめておりますので、下記のリンクをご確認ください。

[1. Hosts configuration](https://github.com/707-Universe/laravel_docker_example/blob/main/.dev/README.md)

### 4. Dockerで開発を始めよう

<http://laravel.test/>

Dockerコンテナの起動が完了すると、上記URLでLaravelにアクセスできるようになります。
