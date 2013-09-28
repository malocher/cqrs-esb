<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test1;

use Cqrs\Bus\AbstractBus;

/**
 * Class Test1Bus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test1
 */
class Test1Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-integration-test1-bus';
    }
}
