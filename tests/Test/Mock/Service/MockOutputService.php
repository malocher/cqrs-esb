<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Mock\Service;

use Test\Mock\Command\MockCommand;
use Test\Mock\Event\MockEvent;

class MockOutputService {

    /**
     * @Cqrs\Annotation\Event("Test\Mock\Event\MockEvent")
     */
    public function getXml(MockEvent $event)
    {
        var_dump(__METHOD__);
        var_dump($event);
    }

    /**
     * @Cqrs\Annotation\Event("Test\Mock\Event\MockEvent")
     */
    public function getJson(MockEvent $event)
    {
        var_dump(__METHOD__);
        var_dump($event);
    }

}