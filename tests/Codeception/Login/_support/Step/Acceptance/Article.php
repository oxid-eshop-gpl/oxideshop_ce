<?php
namespace Step\Acceptance;

use Page\CurrencyMenu;

class Article
{
    protected $user;

    private $articleList;

    public function __construct(\AcceptanceTester $I, $articleList = null)
    {
        $this->user = $I;
        $this->articleList = $articleList;
    }

    public function viewPrice($price)
    {
        $this->user->see($price, $this->articleList);
    }

    public function viewTitle($title)
    {
        $this->user->see($title, $this->articleList);
    }

}