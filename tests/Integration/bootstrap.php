<?php

require_once __DIR__ . '/../' . 'bootstrap.php';

setupShopDatabase();

function setupShopDatabase()
{
    $facts = new \OxidEsales\Facts\Facts();
    exec(
        $facts->getCommunityEditionRootPath() .
        '/bin/oe-console oe:database:reset' .
        ' --db-host=' . $facts->getDatabaseHost() .
        ' --db-port=' . $facts->getDatabasePort() .
        ' --db-name=' . $facts->getDatabaseName() .
        ' --db-user=' . $facts->getDatabaseUserName() .
        ' --db-password=' . $facts->getDatabasePassword() .
        ' --force'
    );
}