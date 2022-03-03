<?php

function autoloader($className): void
{
    $classFileName = $_SERVER['DOCUMENT_ROOT'] . '\packages\\' . $className . '.php';
    include_once ($classFileName);
}

spl_autoload_register('autoloader');