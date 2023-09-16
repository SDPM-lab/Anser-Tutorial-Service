# Anser Tutorial Service

Anser 示範服務

## 環境需求

這些服務依賴 Anser 其他的 Demo Service 服務，請先確認其他服務已經啟動。

* [User_service](https://github.com/SDPM-lab/User_service)
* [Production_service](https://github.com/SDPM-lab/Production_service)
* [Order_service](https://github.com/SDPM-lab/Order_service)

## 指令

### 初始次部署
初次部署環境請記得建立 `anser_project_network` 網路，以利服務間的溝通。

`docker network create anser_project_network`

### 啟動環境
`docker compose up` 或 `docker compose up -d`

### 關閉開發環境
`docker compose down`

### 進入容器
`docker compose exec app bash`

### 初始化專案

* 進入容器後，請執行以下指令：
    ```bash
    composer install
    ```
* 或是在容器外執行：
    ```bash
    docker compose exec app composer install
    ```
