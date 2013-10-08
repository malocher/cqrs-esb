<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iteration;

use Cqrs\Command\ClassMapCommandHandlerLoader;
use Cqrs\Configuration\Setup;
use Cqrs\Event\ClassMapEventListenerLoader;
use Cqrs\Gate;
use Cqrs\Query\ClassMapQueryHandlerLoader;
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
                [
                    'class' => 'Cqrs\Adapter\AnnotationAdapter',
                    'buses' => [
                        'Iteration\Iteration5\Iteration5Bus' => [
                            'Iteration\Iteration5\Iteration5Handler'
                        ],
                        'Cqrs\Bus\SystemBus' => [
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