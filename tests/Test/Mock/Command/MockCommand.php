<?php
namespace Test\Mock\Command;

use Cqrs\Message;
use Cqrs\Command\CommandInterface;

class MockCommand extends Message implements CommandInterface
{
}
