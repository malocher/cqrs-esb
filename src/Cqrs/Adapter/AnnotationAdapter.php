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
    public function __construct()
    {
        AnnotationRegistry::registerAutoloadNamespace('Cqrs\\Annotation\\');
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * Allow
     *
     * Link a Class (probably a service) to a service!
     * Note that we actually __allow__ a class to read/write to a bus.
     *
     * If you want the same class to listen to multiple bussystems then re-call route!!
     *
     * Example:
     *
     * route( 'system-bus', 'service-1' )
     * route( 'system-bus', 'service-2' )
     * route( 'system-err', 'service-1' )
     * route( 'system-err', 'service-2' )
     * ...
     *
     * Have a look into the example Services which use Annotations map commands
     *
     * - - - - - - - - - - - - - - - - - - -
     *
     + class MockBarService
     * **
     * * @Cqrs\Annotation\Command("Test\Mock\Command\MockCommand")
     * *
     * public function getBar($command)
     * - - - - - - - - - - - - - - - - - - -
     *
     * @todo Caching
     * @todo AbstractBus->mapCommand : remove indexed caching - we should not take the command as key !?
     *
     * @param BusInterface  $bus
     * @param String        $qualifiedClassname
     */
    public function allow(BusInterface $bus,$qualifiedClassname)
    {
        $reflClass = new \ReflectionClass($qualifiedClassname);
        $reflMs = $reflClass->getMethods();

        foreach($reflMs as $reflM){
            // command mapping
            $aCommand = $this->annotationReader->getMethodAnnotation($reflM,'Cqrs\Annotation\Command');
            if($aCommand){
                $bus->mapCommand($aCommand->getClass(),array('alias'=>$reflM->class,'method'=>$reflM->name));
            }
            // event registering
            $aEvent = $this->annotationReader->getMethodAnnotation($reflM,'Cqrs\Annotation\Event');
            if($aEvent){
                $bus->registerEventListener($aEvent->getClass(),array('alias'=>$reflM->class,'method'=>$reflM->name));
            }
        }

    }
}