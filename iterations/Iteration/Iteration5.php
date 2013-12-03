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
use Iteration\Iteration5\Iteration5Command;

require dirname(dirname(__DIR__)) . '/bootstrap.php';

/**
 * Class Iteration5
 *
 * Configuration using Setup
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Iteration
 */
class Iteration5
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

        // iteration 5
        $configuration = [
            'adapters' => [
                'Malocher\Cqrs\Adapter\AnnotationAdapter' => [
                    'buses' => [
                        'Iteration\Iteration5\Iteration5Bus' => [
                            'Iteration\Iteration5\Iteration5Handler'
                        ],
                        'Malocher\Cqrs\Bus\SystemBus' => [
                            'Iteration\Iteration5\Iteration5Monitor'
                        ]
                    ]
                ],
            ],
        ];
        $setup->initialize($configuration);

        $bus = $setup->getGate()->getBus('iteration-iteration5-bus');
        $bus->invokeCommand(new Iteration5Command('Hello'));
    }

}


new Iteration5();