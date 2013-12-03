<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration3;

use Malocher\Cqrs\Bus\AbstractBus;

/**
 * Class Iteration3Bus
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration3
 */
class Iteration3Bus extends AbstractBus
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'iteration-iteration3-bus';
    }
}
