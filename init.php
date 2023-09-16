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
