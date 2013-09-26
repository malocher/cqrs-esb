<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;

use Test\Coverage\Cqrs\Bus\BusInterfaceTest;
use Test\TestCase;

/**
 * Description of ArrayMapAdapterTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class ArrayMapAdapterTest extends TestCase implements AdapterInterfaceTest
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
    public function pipe(BusInterfaceTest $bus, array $configuration)
    {
        /*foreach ($configuration as $messageClass => $callableOrDefinition) {
            if ($this->isCommand($messageClass)) {
                $bus->mapCommand($messageClass, $callableOrDefinition);
            } else if ($this->isEvent($messageClass)) {
                $bus->registerEventListener($messageClass, $callableOrDefinition);
            } else {
                throw new \Exception(
                    sprintf(
                        'Message <%s> must implement %s or %s',
                        $messageClass,
                        'Cqrs\Command\CommandInterface',
                        'Cqrs\Event\EventInterface'
                    )
                );
            }
        }*/
    }
    
    /**
     * Check if message implements Cqrs\Command\CommandInterface
     * 
     * @param string $messageClass
     * @return boolean
     */
    private function isCommand($messageClass) {
        /*$interfaces = class_implements($messageClass);
        
        if (!$interfaces) {
            return false;
        }
        
        return in_array('Cqrs\Command\CommandInterface', $interfaces);*/
    }
    
    /**
     * Check if message implements Cqrs\Command\CommandInterface
     * 
     * @param string $messageClass
     * @return boolean
     */
    private function isEvent($messageClass) {
        /*$interfaces = class_implements($messageClass);
        
        if (!$interfaces) {
            return false;
        }
        
        return in_array('Cqrs\Event\EventInterface', $interfaces);*/
    }
}
