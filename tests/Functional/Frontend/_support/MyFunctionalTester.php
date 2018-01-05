<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/

class MyFunctionalTester extends \Codeception\Actor
{
    use _generated\MyFunctionalTesterActions;

   /**
    * Define custom actions here
    */

    public function haveInDatabase($table, $arguments)
    {
        $container = \Codeception\Util\Stub::make('Codeception\Lib\ModuleContainer');
        $database = new \Codeception\Module\Db($container);

        $config = [
            'dsn' => 'mysql:host=localhost;dbname=oxid',
            'user' => 'oxid',
            'password' => 'oxid',
            'cleanup' => false
        ];

        $database->_setConfig($config);
        $database->_initialize();

        $database->seeInDatabase($table, $arguments);
    }
}
