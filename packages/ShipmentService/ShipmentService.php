<?php

namespace ShipmentService;

use DateTime;
use DBConnection\DBConnection;

class ShipmentService
{
    private DBConnection $dBConnection;

    public function __construct(DBConnection $dBConnection)
    {
        $this->dBConnection = $dBConnection;
    }

    public function getShipmentUntilDate(DateTime $date): array
    {
        $dateString = $date->format('Y-m-d');
        $query = "SELECT * FROM shipment WHERE date <= '$dateString'";
        $queryResult = $this->dBConnection->query($query);
        $shipmentCollection = [];
        while ($row = $queryResult->fetch()) {
            $shipmentCollection[] = new ShipmentElem($row);
        }
        return $shipmentCollection;
    }

    public function getShipmentByDate(DateTime $date): array
    {
        $dateString = $date->format('Y-m-d');
        $query = "SELECT * FROM shipment WHERE date = '$dateString'";
        $queryResult = $this->dBConnection->query($query);
        $shipmentCollection = [];
        while ($row = $queryResult->fetch()) {
            $shipmentCollection[] = new ShipmentElem($row);
        }
        return $shipmentCollection;
    }
}