<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration\Integration4;

use Malocher\Cqrs\Bus\AbstractBus;

/**
 * Class Integration4Bus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Integration\Integration4
 */
class Integration4Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-integration-Integration4-bus';
    }
}
