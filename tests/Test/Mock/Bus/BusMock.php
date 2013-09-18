<?php
namespace Test\Mock\Bus;

use Cqrs\Bus\AbstractBus;

class BusMock extends AbstractBus
{
    public function getName()
    {
        return 'mock_bus';
    }    
}
