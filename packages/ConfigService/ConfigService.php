<?php

namespace ConfigService;

class ConfigService
{
    private array $configData;

    public function __construct()
    {
        $configFile = $_SERVER['DOCUMENT_ROOT'] . '/core/config.php';
        $this->configData = include_once $configFile;
    }

    public function getDbConfig(): array
    {
        return $this->configData['dbConfig'];
    }
}