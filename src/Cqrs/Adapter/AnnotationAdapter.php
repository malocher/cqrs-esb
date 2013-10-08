<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Bus\BusInterface;

/**
 * Class AnnotationAdapter
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Adapter
 */
class AnnotationAdapter implements AdapterInterface
{
    /**
     * @param array $configuration
     */
    public function __construct(array $configuration = null)
    {
    }

    /**
     * Initialize (pipe) a bus via configuration file!
     *
     * @param \Cqrs\Bus\BusInterface $bus
     * @param array $configuration
     */
    public function pipe(BusInterface $bus, array $configuration)
    {
        foreach ($configuration as $qualifiedClassnameOfHandlerOrListener) {
            $this->allow($bus, $qualifiedClassnameOfHandlerOrListener);
        }
    }

    /**
     * Allow
     *
     * Link a Class (probably a handler) to a handler!
     * Note that we actually __allow__ a class to read/write to a bus.
     *
     * If you want the same class to listen to multiple bussystems then re-call route!!
     *
     * Example:
     *
     * route( 'system-bus', 'handler-1' )
     * route( 'system-bus', 'handler-2' )
     * route( 'system-err', 'handler-1' )
     * route( 'system-err', 'handler-2' )
     * ...
     *
     * Have a look into the example Handlers which use Annotations map commands
     *
     * - - - - - - - - - - - - - - - - - - -
     *
     * + class MockBarHandler
     * **
     * * @command Test\Mock\Command\MockCommand
     * *
     * public function getBar($command)
     * - - - - - - - - - - - - - - - - - - -
     *
     * @param BusInterface $bus
     * @param String $qualifiedClassname
     * @throws AdapterException
     */
    private function allow(BusInterface $bus, $qualifiedClassname)
    {
        if (!class_exists($qualifiedClassname)) {
            throw AdapterException::initializeError(sprintf('Class <%s> does not exist', $qualifiedClassname));
        }
        $reflClass = new \ReflectionClass($qualifiedClassname);
        $reflMs = $reflClass->getMethods();

        foreach ($reflMs as $reflM) {

            if (preg_match_all('~@(command|event|query)\s+(\S+)~i', $reflM->getDocComment(), $annotations, PREG_SET_ORDER) > 0) {
                foreach ($annotations as $class) {
                    $qualifiedClassname = $class[2];
                    if (false === class_exists($qualifiedClassname)) {
                        throw AdapterException::annotationError(sprintf('Class <%s> does not exist', $qualifiedClassname));
                    }
                    if (isset(class_implements($qualifiedClassname)['Cqrs\Command\CommandInterface'])) {
                        $bus->mapCommand($qualifiedClassname, array('alias' => $reflM->class, 'method' => $reflM->name));
                    }
                    if (isset(class_implements($qualifiedClassname)['Cqrs\Event\EventInterface'])) {
                        $bus->registerEventListener($qualifiedClassname, array('alias' => $reflM->class, 'method' => $reflM->name));
                    }
                    if (isset(class_implements($qualifiedClassname)['Cqrs\Query\QueryInterface'])) {
                        $bus->mapQuery($qualifiedClassname, array('alias' => $reflM->class, 'method' => $reflM->name));
                    }
                }
            }
        }
    }
}