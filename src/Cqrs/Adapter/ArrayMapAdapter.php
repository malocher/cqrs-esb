<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Bus\BusInterface;

/**
 * Description of ArrayMapAdapter
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ArrayMapAdapter implements AdapterInterface
{
    /**
     * 
     * {@inheritDoc}
     */
    public function __construct(array $configuration = null)
    {
        //empty constructor, just here to implement the interface
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function pipe(BusInterface $bus, array $configuration)
    {
        if (isset($configuration['command_map'])) {
            foreach ($configuration['command_map'] as $commandClass => $callableOrDefinition) {
                $bus->mapCommand($commandClass, $callableOrDefinition);
            }
        }
        
        if (isset($configuration['event_map'])) {
            foreach ($configuration['event_map'] as $eventClass => $callableOrDefinition) {
                $bus->registerEventListener($eventClass, $callableOrDefinition);
            }
        }
    }    
}
