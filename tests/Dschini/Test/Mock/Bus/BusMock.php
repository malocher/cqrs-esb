<?php
namespace Dschini\Test\Mock\Bus;

use Dschini\Cqrs\Bus\AbstractBus;

class BusMock extends AbstractBus
{
    public function getName()
    {
        return 'mock_bus';
    }    
}
