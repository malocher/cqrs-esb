<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Malocher\Test\Integration\Iteration;

use Malocher\Test\TestCase;
use Behat\Mink\Session;
use Behat\Mink\Driver\GoutteDriver;
/**
 *  Iteration1Test
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class Iteration1Test extends TestCase
{
    /**
     *
     * @var Session
     */
    protected $minkSession;
    
    protected function setUp()
    {
        $driver = new GoutteDriver();
        
        $this->minkSession = new \Behat\Mink\Session($driver);
        
        $this->minkSession->start();
    }
    
    public function testIteration1()
    {
        //This is a proposel for testing the iterations, but we should think about
        //using a config file to define the base url like you could do in behat.yml (may we should use Behat feature tests?)
        //Other question is, should we exclude the tests from Travis-CI?
        //Comment out following line to run the test and see how it works
        $this->markTestIncomplete();
        
        $this->minkSession->visit('http://localhost/' . $this->getRootDirName() . '/iterations/Iteration/Iteration1.php');
        
        $this->assertEquals(
            "Iteration\Iteration1\Iteration1Handler::editCommand says: Hello ... Command\nIteration\Iteration1\Iteration1Handler::editEvent says: Hello ... Event", 
            $this->minkSession->getPage()->getContent()
        );
    }
}
