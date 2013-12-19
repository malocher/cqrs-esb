<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Coverage\Mock\Bus;

use Malocher\Cqrs\Bus\AbstractBus;

/**
 * Class MockAnotherBus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Coverage\Mock\Bus
 */
class MockAnotherBus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-coverage-mock-another-bus';
    }
}
