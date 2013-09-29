<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Example\Example2;

use Cqrs\Bus\AbstractBus;

/**
 * Class Example2Bus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example\Example2
 */
class Example2Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'test-integration-test1-bus';
    }
}
