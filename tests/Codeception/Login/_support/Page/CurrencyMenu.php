<?php
namespace Page;

class CurrencyMenu
{
    // include url of current page
    public static $URL = '';

    public static $currencyMenuButton = "//div[@class='btn-group currencies-menu']/button";

    public static $openedCurrencyMenuButton = "//div[@class='btn-group currencies-menu open']";

    public static $currencyMenuTitle = "//div[@class='btn-group currencies-menu']/button";

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    public static function getItem($item)
    {
        return self::$openedCurrencyMenuButton . "/ul[@class='dropdown-menu dropdown-menu-right']/li[" . $item . "]";
    }

    public static function getActiveItem()
    {
        return self::$openedCurrencyMenuButton . "/ul[@class='dropdown-menu dropdown-menu-right']/li[@class='active']";
    }
}
