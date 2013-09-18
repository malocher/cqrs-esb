<?php
namespace Test\Mock\Command;

use Cqrs\Command\CommandInterface;
use Cqrs\Gate;

class MockCommandHandler
{
    
    public function handleCommand(CommandInterface $command, Gate $gate)
    {
        if ($command instanceof MockCommand) {
            $command->edit();
        }
    }  
}
