<?php
namespace Test\Mock\Command;

use Cqrs\Command\CommandHandlerInterface;
use Cqrs\Command\CommandInterface;
use Cqrs\Gate;

class MockCommandHandler implements CommandHandlerInterface
{
    
    public function handleCommand(CommandInterface $command, Gate $gate)
    {
        if ($command instanceof MockCommand) {
            return true;
        }
        
        return false;
    }  
}
