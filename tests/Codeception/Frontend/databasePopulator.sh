#!/usr/bin/env php
<?php

require_once dirname(dirname(dirname(__DIR__)))  . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$facts = new \OxidEsales\Facts\Facts;

$pathToTestData = $facts->getShopRootPath() . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'Codeception' .
                  DIRECTORY_SEPARATOR . 'Frontend' . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR .
                  'database_with_testdata_CE.sql';
if ($facts->isEnterprise()) {
   $pathToTestData = $facts->getEnterpriseEditionRootPath() . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR .
                    'Acceptance' . DIRECTORY_SEPARATOR . 'Frontend' . DIRECTORY_SEPARATOR . 'testSql' .
                    DIRECTORY_SEPARATOR . 'demodata_EE.sql';
}

$databaseName = $facts->getDatabaseName();
$dbHost = $facts->getDatabaseHost();
$dbUser = $facts->getDatabaseUserName();
$dbPassword = $facts->getDatabasePassword();

$populationCommand = "mysql -u{$dbUser} -p{$dbPassword} -h{$dbHost} {$databaseName} <  {$pathToTestData}";
exec($populationCommand, $output, $returnValue);
