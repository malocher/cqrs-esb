<?php
namespace Test\Mock\Command;

use Cqrs\Event\EventInterface;
use Cqrs\Message;

class MockEvent extends Message implements EventInterface
{
}
