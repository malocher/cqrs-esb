<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Bus;

use Cqrs\Bus\AbstractBus;

/**
 * Class MockFakeSystemBus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Coverage\Mock\Bus
 */
class MockFakeSystemBus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'system-bus';
    }
}
