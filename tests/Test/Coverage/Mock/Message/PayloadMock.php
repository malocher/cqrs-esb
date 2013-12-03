<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Mock\Message;

use Malocher\Cqrs\Message\PayloadInterface;
/**
 *  PayloadMock
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class PayloadMock implements PayloadInterface
{
    protected $payloadArray = array();
    
    public function __set($name, $value)
    {
        $this->payloadArray[$name] = $value;
    }


    public function getArrayCopy()
    {
        return $this->payloadArray;
    }    
}
