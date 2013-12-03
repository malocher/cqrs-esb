<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test4;

use Malocher\Cqrs\Event\EventInterface;
use Malocher\Cqrs\Message\Message;

/**
 * Class Test4Event
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test\Integration\Test4
 */
class Test4Event extends Message implements EventInterface
{
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
