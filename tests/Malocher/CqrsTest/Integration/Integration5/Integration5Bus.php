<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration5;

use Malocher\Cqrs\Bus\AbstractBus;

/**
 * Class Integration5Bus
 * @package Malocher\CqrsTest\Integration\Integration5
 */
class Integration5Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-integration-Integration5-bus';
    }
}
