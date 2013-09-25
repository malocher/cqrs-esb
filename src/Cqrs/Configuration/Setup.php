<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Configuration;

use Cqrs\Gate;
use Cqrs\Bus\BusInterface;
use Cqrs\Adapter\AdapterInterface;
use Cqrs\Command\CommandHandlerLoaderInterface;
use Cqrs\Event\EventListenerLoaderInterface;
/**
 * Description of CQRS Setup class
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Setup
{
    /**
     *
     * @var Gate 
     */
    protected $gate;
    
    /**
     *
     * @var CommandHandlerLoaderInterface
     */
    protected $commandHandlerLoader;
    
    /**
     *
     * @var EventListenerLoaderInterface
     */
    protected $eventListenerLoader;


    public function setGate(Gate $gate) {
        $this->gate = $gate;
    }
    
    public function setCommandHandlerLoader(CommandHandlerLoaderInterface $commandHandlerLaoder) {
        $this->commandHandlerLoader = $commandHandlerLaoder;
    }
    
    /**
     * 
     * @return CommandHandlerLoaderInterface
     */
    public function getCommandHandlerLoader() {
        return $this->commandHandlerLoader;
    }
    
    public function setEventListenerLoader(EventListenerLoaderInterface $eventListenerLoader) {
        $this->eventListenerLoader = $eventListenerLoader;
    }

    /**
     * 
     * @return EventListenerLoaderInterface
     */
    public function getEventListenerLoader() {
        return $this->eventListenerLoader;
    }

    public function initialize(array $configuration) {
        
        if (isset($configuration['enable_system_bus']) && $configuration['enable_system_bus']) {
            $this->gate->enableSystemBus();
        }
        
        $adapter = $this->loadAdapter($configuration);
        
        
        
        foreach($configuration['buses'] as $busClass => $busAdapterConfiguration) {
            $bus = $this->loadBus($busClass);
            $adapter->pipe($bus, $busAdapterConfiguration);
        }
    }
    
    /**
     * 
     * @param array $configuration
     * 
     * @return AdapterInterface
     */
    protected function loadAdapter(array $configuration) {
        $adapterClass = $configuration['adapter']['class'];
        $config = isset($configuration['adapter']['options'])? $configuration['adapter']['options'] : null;
        
        return new $adapterClass($config);
    }
    
    /**
     * 
     * @param string $busClass
     * 
     * @return BusInterface
     */
    protected function loadBus($busClass) {
        $bus = new $busClass($this->getCommandHandlerLoader(), $this->getEventListenerLoader());
        $this->gate->attach($bus);
        return $bus;
    }
}
