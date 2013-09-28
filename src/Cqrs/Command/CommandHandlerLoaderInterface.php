<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Command;

/**
 * Interface CommandHandlerLoaderInterface
 *
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 * @package Cqrs\Command
 */
interface CommandHandlerLoaderInterface
{
    /**
     * Take an alias and get/create an instance of CommandHandlerInterface
     *
     * @param $alias callable alias that is known by the command handler loader
     * @return mixed
     */
    public function getCommandHandler($alias);
}
