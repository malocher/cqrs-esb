<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs\Interfaces;

/**
 * FactoryInterfaces
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
interface FactoryInterface {

    public static function create();

}