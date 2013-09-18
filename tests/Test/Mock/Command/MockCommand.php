<?php
namespace Test\Mock\Command;

use Cqrs\Message;
use Cqrs\Command\CommandInterface;

class MockCommand extends Message implements CommandInterface
{
    protected $edited = false;
    
    public function edit() {
        $this->edited = true;
    }
    
    public function isEdited() {
        return $this->edited;
    }
}
