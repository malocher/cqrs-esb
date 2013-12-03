<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iteration;

use Malocher\Cqrs\Command\ClassMapCommandHandlerLoader;
use Malocher\Cqrs\Configuration\Setup;
use Malocher\Cqrs\Event\ClassMapEventListenerLoader;
use Malocher\Cqrs\Gate;
use Malocher\Cqrs\Query\ClassMapQueryHandlerLoader;
use Iteration\Iteration6\Iteration6Command;
use Iteration\Iteration6\Iteration6Query;

require dirname(dirname(__DIR__)) . '/bootstrap.php';

/**
 * Class Iteration6
 *
 * Configuration using Setup
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration6
{
    /**
     *
     */
    public function __construct()
    {
        $setup = new Setup();
        $setup->setGate(new Gate());
        $setup->setCommandHandlerLoader(new ClassMapCommandHandlerLoader());
        $setup->setEventListenerLoader(new ClassMapEventListenerLoader());
        $setup->setQueryHandlerLoader(new ClassMapQueryHandlerLoader());

        // iteration 6
        $configuration = [
            'adapters' => [
                'Malocher\Cqrs\Adapter\AnnotationAdapter' => [ 
                    'buses' => [
                        'Iteration\Iteration6\Iteration6Bus' => [
                            'Iteration\Iteration6\Iteration6Handler'
                        ],
                        'Malocher\Cqrs\Bus\SystemBus' => [
                            'Iteration\Iteration6\Iteration6Monitor'
                        ]
                    ]
                ],
            ],
        ];
        $setup->initialize($configuration);

        $bus = $setup->getGate()->getBus('iteration-iteration6-bus');
        $bus->invokeCommand(new Iteration6Command('Hello'));
        echo $bus->executeQuery(new Iteration6Query('Hello'));
    }

}


new Iteration6();