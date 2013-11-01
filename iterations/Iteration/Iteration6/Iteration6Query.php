<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Iteration\Iteration6;

use Cqrs\Message\Message;
use Cqrs\Query\QueryInterface;

/**
 * Class Iteration6Query
 *
 * The Version property refers to the version of the aggregate.
 * The version is incremented whenever the aggregate receives a new event.
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration\Iteration6
 */
class Iteration6Query extends Message implements QueryInterface
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
