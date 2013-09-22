<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Bus;

use Cqrs\Bus\AbstractBus;
use Cqrs\Command\CommandInterface;
use Cqrs\Event\EventInterface;

class SystemBus extends AbstractBus
{
    public function getName()
    {
        return 'system-bus';
    }

    /**
     * {@inheritDoc}
     */
    public function invokeCommand(CommandInterface $command)
    {
        $commandClass = get_class($command);

        if( !isset($this->commandHandlerMap[$commandClass]) ){
            return;
        }

        foreach($this->commandHandlerMap[$commandClass] as $i => $callableOrDefinition) {

            // @todo how will this work with traits ?

            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $command);
                //return;
            }

            if (is_array($callableOrDefinition)) {
                $commandHandler = $this->commandHandlerLoader->getCommandHandler($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                $usedTraits = class_uses($commandHandler);
                if( !isset($usedTraits['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $commandHandler->executeCommand($this->gate,$commandHandler,$method,$command);
                //$commandHandler->{$method}($command);
                //return;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function publishEvent(EventInterface $event)
    {
        $eventClass = get_class($event);

        if(!isset($this->eventListenerMap[$eventClass])){
            return;
        }

        foreach($this->eventListenerMap[$eventClass] as $i => $callableOrDefinition) {
            if (is_callable($callableOrDefinition)) {
                call_user_func($callableOrDefinition, $event);
                //return;
            }

            if (is_array($callableOrDefinition)) {
                $eventListener = $this->eventListenerLoader->getEventListener($callableOrDefinition['alias']);
                $method = $callableOrDefinition['method'];

                /* instead of invoking the handler method directly
                 * we call the execute function of the implemented trait and pass along a reference to the gate
                 */
                $usedTraits = class_uses($eventListener);
                if( !isset($usedTraits['Cqrs\Adapter\AdapterTrait']) ){
                    throw BusException::traitError('Adapter Trait is missing! Use it!');
                }
                $eventListener->executeEvent($this->gate,$eventListener,$method,$event);
                //$eventListener->{$method}($event);
                //return;
            }
        }
    }
}