<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Bus\BusInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * AnnotationAdapter
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class AnnotationAdapter implements AdapterInterface {

    /**
     * @var AnnotationReader
     */
    public $annotationReader;

    /**
     * Constructor
     */
    public function __construct(array $configuration = null)
    {
        AnnotationRegistry::registerAutoloadNamespace('Cqrs\\Annotation\\');
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * Initialize a bus via Configuration file!
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
     + class MockBarHandler
     * **
     * * @Cqrs\Annotation\Command("Test\Mock\Command\MockCommand")
     * *
     * public function getBar($command)
     * - - - - - - - - - - - - - - - - - - -
     *
     * @param BusInterface  $bus
     * @param String        $qualifiedClassname
     * @throws AdapterException
     */
    public function allow(BusInterface $bus,$qualifiedClassname)
    {
        $reflClass = new \ReflectionClass($qualifiedClassname);
        $reflMs = $reflClass->getMethods();

        foreach($reflMs as $reflM){
            // command mapping
            $aCommand = $this->annotationReader->getMethodAnnotation($reflM,'Cqrs\Annotation\Command');
            if($aCommand){
                if( !class_exists($aCommand->getClass()) ){
                    throw AdapterException::annotationError(sprintf('Command <%s> does not exists or wrong annotation!',
                        $aCommand->getClass()));
                }
               $bus->mapCommand($aCommand->getClass(),array('alias'=>$reflM->class,'method'=>$reflM->name));
            }

            // event registering
            $aEvent = $this->annotationReader->getMethodAnnotation($reflM,'Cqrs\Annotation\Event');
            if($aEvent){
                if( !class_exists($aEvent->getClass()) ){
                    throw AdapterException::annotationError(sprintf('Event <%s> does not exist or wrong annotation!',
                        $aEvent->getClass()));
                }
                $bus->registerEventListener($aEvent->getClass(),array('alias'=>$reflM->class,'method'=>$reflM->name));
            }

        }
    }
}