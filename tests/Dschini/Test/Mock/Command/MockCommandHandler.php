<?php
namespace Dschini\Test\Mock\Command;

use Dschini\Cqrs\Command\CommandHandlerInterface;
use Dschini\Cqrs\Command\CommandInterface;
use Dschini\Cqrs\Gate;

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
