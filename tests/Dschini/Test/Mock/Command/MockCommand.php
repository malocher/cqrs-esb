<?php
namespace Dschini\Test\Mock\Command;

use Dschini\Cqrs\Command\CommandInterface;

class MockCommand implements CommandInterface
{
    protected $arguments = array();
    
    public function __construct(array $arguments = null)
    {
        if (!is_null($arguments)) {
            $this->arguments = $arguments;
        }
    }

    public function getArguments()
    {
        return $this->arguments;
    }    
}
