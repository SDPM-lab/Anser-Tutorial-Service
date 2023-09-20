<?php

require_once './vendor/autoload.php';

use SDPMlab\Anser\Service\ServiceList;

ServiceList::addLocalService(
    name: "ProductionService",
    address: "production-service",
    port: 8080,
    isHttps: false
);

ServiceList::addLocalService(
    name: "UserService",
    address: "user-service",
    port: 8080,
    isHttps: false
);

ServiceList::addLocalService(
    name: "OrderService",
    address: "order-service",
    port: 8080,
    isHttps: false
);

//定義常數 Log 位置
define("LOG_PATH", __DIR__ . DIRECTORY_SEPARATOR ."Logs" . DIRECTORY_SEPARATOR);