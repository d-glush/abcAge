<?php

namespace WarehouseService;

use DateInterval;
use DateTime;
use DBConnection\DBConnection;
use ShipmentService\ShipmentElem;
use ShipmentService\ShipmentService;

class WarehouseService
{
    private DBConnection $dBConnection;
    private ShipmentService $shipmentService;

    public function __construct(ShipmentService $shipmentService, DBConnection $dBConnection)
    {
        $this->dBConnection = $dBConnection;
        $this->shipmentService = $shipmentService;
    }

    /**
     * @return array<WarehouseProduct>
     */
    public function getWarehouse(): array
    {
        $warehouseCollection = [];

        $queryText = 'SELECT * FROM warehouse';
        $queryResult = $this->dBConnection->query($queryText);
        while ($row = $queryResult->fetch()) {
            $warehouseCollection[] = new WarehouseProduct($row);
        }

        return $warehouseCollection;
    }

    public function resetData(): void
    {
        $clearQuery = 'TRUNCATE TABLE warehouse;';
        $this->dBConnection->execute($clearQuery);
        $fillQuery = "INSERT INTO warehouse VALUES 
                             (1, 'Колбаса', 0, 0), 
                             (2, 'Пармезан', 0, 0), 
                             (3, 'Левый носок', 0, 0);";
        $this->dBConnection->execute($fillQuery);
    }

    public function simulateShoppingUntil(DateTime $untilDate): int
    {
        $shoppingDate = new DateTime('2021-01-12');
        $preCalcDate = min($untilDate, $shoppingDate);
        $this->collectShipmentUntilDate($preCalcDate);
        $shoppingDate->add(new DateInterval('P1D'));

        $demandByDay = [1, 1];
        $currShoppingDay = 1;
        $prevDayPreOrder = 0;
        $priceLabel = 0;
        while($shoppingDate <= $untilDate) {
            $this->collectShipmentByDate($shoppingDate);
            $preOrderCount = $demandByDay[$currShoppingDay - 1];

            $sockWarehouse = $this->getWarehouseProductByName('Левый носок');

            if ($preOrderCount > 0) {
                $this->sellProductByName('Левый носок', $preOrderCount);
            }
            if ($prevDayPreOrder > 0) {
                $priceLabel = $prevDayPreOrder * $sockWarehouse->getPrice();
            }

            $prevDayPreOrder = $preOrderCount;
            $demandByDay[] = $demandByDay[$currShoppingDay - 1] + $demandByDay[$currShoppingDay];
            $currShoppingDay++;
            $shoppingDate->add(new DateInterval('P1D'));
        }

        return $priceLabel;
    }

    private function sellProductByName(string $name, int $quantity) {
        $queryText = "UPDATE warehouse SET quantity = quantity - $quantity WHERE product_name = '$name'";
        $this->dBConnection->execute($queryText);
    }

    private function collectShipmentUntilDate(DateTime $date): void
    {
        $shipmentCollection = $this->shipmentService->getShipmentUntilDate($date);
        $this->putShipmentCollection($shipmentCollection);
    }

    private function collectShipmentByDate(DateTime $date): void
    {
        $shipmentCollection = $this->shipmentService->getShipmentByDate($date);
        $this->putShipmentCollection($shipmentCollection);
    }

    private function getWarehouseProductByName($productName): WarehouseProduct
    {
        $queryText = "SELECT * FROM warehouse WHERE product_name='$productName'";
        $queryResult = $this->dBConnection->query($queryText);
        return new WarehouseProduct($queryResult->fetch());
    }

    private function putShipmentCollection(array $shipmentCollection): void
    {
        foreach ($shipmentCollection as $shipmentElem) {
            $this->putShipment($shipmentElem);
        }
    }

    private function putShipment(ShipmentElem $shipment): void
    {
        $addQuantity = $shipment->getQuantity();
        $name = $shipment->getProductName();
        $price = $shipment->getPrice() / $addQuantity;
        $queryText = "UPDATE warehouse 
            SET price = (quantity * price + $addQuantity * $price) / (quantity + $addQuantity), 
                quantity = quantity + $addQuantity
            WHERE product_name = '$name'";
        $this->dBConnection->execute($queryText);
    }
}