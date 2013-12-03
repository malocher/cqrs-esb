<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;
/**
 * Class SystemBus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Bus
 */
class SystemBus extends AbstractBus
{
    /**
     * get name of the bus
     *
     * @return string
     */
    public function getName()
    {
        return self::SYSTEMBUS;
    }
}