<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration\Integration4;

use Malocher\Cqrs\Command\CommandInterface;
use Malocher\Cqrs\Message\Message;

/**
 * Class Integration4Command
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Malocher\Test\Integration\Integration4
 */
class Integration4Command extends Message implements CommandInterface
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
