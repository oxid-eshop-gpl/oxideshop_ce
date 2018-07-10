<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:42
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use Symfony\Component\EventDispatcher\Event;

class TestEvent extends Event
{
    private $counter = 0;

    public function getNumberOfActiveHandlers()
    {
        return $this->counter;
    }

    public function handleEvent()
    {
        $this->counter++;
    }

}