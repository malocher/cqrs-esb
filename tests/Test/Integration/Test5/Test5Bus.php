<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test5;

use Malocher\Cqrs\Bus\AbstractBus;

/**
 * Class Test5Bus
 * @package Test\Integration\Test5
 */
class Test5Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-integration-test5-bus';
    }
}
