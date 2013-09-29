<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Example\Example4;

use Cqrs\Adapter\AdapterTrait;

/**
 * Class Example4Handler
 *
 * This Handler class makes use of annotations... thx doctrine!
 * Note the use of the AdapterTrait which loosely couples this file with the cqrs package
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Example\Example4
 */
class Example4Handler
{
    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Example\Example4\Example4Command")
     * @param Example4Command $command
     */
    public function editCommand(Example4Command $command)
    {
        $command->edit();
        print sprintf("%s says: %s ... Command\n", __METHOD__, $command->getArguments());
        $event = new Example4Event('Welcome');
        $event->edit();
        $this->getBus()->publishEvent($event);
    }

    /**
     * @Cqrs\Annotation\Event("Example\Example4\Example4Event")
     * @param Example4Event $event
     */
    public function editEvent(Example4Event $event)
    {
        print sprintf("%s says: %s ... Event\n", __METHOD__, $event->getArguments());
    }
}
