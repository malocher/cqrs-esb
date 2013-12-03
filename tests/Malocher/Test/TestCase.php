<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test;

/**
 * Class TestCase
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Test
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getRootDirName()
    {
        $pathToDir = dirname(realpath(__DIR__ . '/../../'));
        
        $pathToDir  = trim(strrchr($pathToDir, '/'), '/');
        
        return $pathToDir;
    }
}