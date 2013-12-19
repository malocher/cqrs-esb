<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\CqrsTest\Integration\Integration3;

use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Message\Message;

/**
 * Class Integration3Event
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\CqrsTest\Integration\Integration3
 */
class Integration3Event extends Message implements EventInterface
{
    /**
     * @var
     */
    public $callback;

    /**
     * @var bool
     */
    protected $edited = false;

    /**
     *
     */
    public function edit()
    {
        $this->edited = true;
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return $this->edited;
    }
}
