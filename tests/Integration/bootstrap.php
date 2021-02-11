<?php

require_once __DIR__ . '/../' . 'bootstrap.php';

setupShopDatabase();

function setupShopDatabase()
{
    $facts = new \OxidEsales\Facts\Facts();
    $resetDatabaseService = new \OxidEsales\DeveloperTools\Framework\Database\Service\ResetDatabaseService(
        new \OxidEsales\DeveloperTools\Framework\Database\Service\DatabaseChecker(),
        new \OxidEsales\DeveloperTools\Framework\Database\Service\DatabaseCreator(),
        new \OxidEsales\DeveloperTools\Framework\Database\Service\DatabaseInitiator(new \OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContext()),
        new \OxidEsales\DeveloperTools\Framework\Database\Service\DropDatabaseService(),
        new \OxidEsales\DatabaseViewsGenerator\ViewsGenerator()
    );
    $resetDatabaseService->resetDatabase(
        $facts->getDatabaseHost(),
        $facts->getDatabasePort(),
        $facts->getDatabaseUserName(),
        $facts->getDatabasePassword(),
        $facts->getDatabaseName()
    );
}
