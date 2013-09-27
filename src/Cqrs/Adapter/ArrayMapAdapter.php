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
        foreach ($configuration as $messageClass => $callableOrDefinition) {
            if ($this->isCommand($messageClass)) {
                $bus->mapCommand($messageClass, $callableOrDefinition);
            } else if ($this->isEvent($messageClass)) {
                $bus->registerEventListener($messageClass, $callableOrDefinition);
            } else {
                throw AdapterException::pipeError(sprintf(
                    'Message <%s> must implement %s or %s',
                    $messageClass,
                    'Cqrs\Command\CommandInterface',
                    'Cqrs\Event\EventInterface'
                ));
            }
        }
    }
    
    /**
     * Check if message implements Cqrs\Command\CommandInterface
     * 
     * @param string $messageClass
     * @throws AdapterException
     * @return boolean
     */
    private function isCommand($messageClass) {
        if(!class_exists($messageClass)){
            throw AdapterException::initializeError(sprintf('Message class <%s> does not exist',$messageClass));
        }
        $interfaces = class_implements($messageClass);
        if (!$interfaces) {
            return false;
        }
        return in_array('Cqrs\Command\CommandInterface', $interfaces);
    }
    
    /**
     * Check if message implements Cqrs\Command\CommandInterface
     * 
     * @param string $messageClass
     * @throws AdapterException
     * @return boolean
     */
    private function isEvent($messageClass) {
        if(!class_exists($messageClass)){
            throw AdapterException::initializeError(sprintf('Message class <%s> does not exist',$messageClass));
        }
        $interfaces = class_implements($messageClass);
        if (!$interfaces) {
            return false;
        }
        return in_array('Cqrs\Event\EventInterface', $interfaces);
    }
}
