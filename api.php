<?php

use ApiResponse\ApiResponse;
use ConfigService\ConfigService;
use DBConnection\DBConnection;
use ShipmentService\ShipmentService;
use WarehouseService\WarehouseService;

header('Content-type: application/json; charset=UTF-8');

include_once 'core/init.php';

$method = $_GET['method'];
switch ($method) {
    case 'getWarehouse':

        try {
            $date = new DateTime($_GET['date']);
        } catch (Exception $e) {
            (new ApiResponse(['message' => 'wrong date'], 1))->show();
        }

        $configService = new ConfigService();
        $dbConfig = $configService->getDbConfig();
        try {
            $connection = new DBConnection(
                $dbConfig['host'],
                $dbConfig['database'],
                $dbConfig['user'],
                $dbConfig['password'],
            );
        } catch (PDOException $e) {
            (new ApiResponse(['message' => 'server error'], 2))->show();
        }

        $shipmentService = new ShipmentService($connection);
        $warehouseService = new WarehouseService($shipmentService, $connection);
        $warehouseService->resetData();

        try {
            $priceLabel = $warehouseService->simulateShoppingUntil($date);
        } catch (Exception $e) {
            (new ApiResponse(['message' => 'server error'], 2))->show();
        }
        $warehouseCollection = $warehouseService->getWarehouse();
        $warehouse = [];
        foreach ($warehouseCollection as $warehouseProduct) {
            $warehouse[] = $warehouseProduct->getArrayData();
        }
        (new ApiResponse(['priceLabel' => $priceLabel, 'warehouse' => $warehouse], 200))->show();

    default:
        (new ApiResponse(['message' => 'wrong method'], 404))->show();
}