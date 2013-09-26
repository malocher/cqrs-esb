<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Adapter;
use Test\Coverage\Cqrs\Bus\BusInterfaceTest;

/**
 * AdapterInterface
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
interface AdapterInterfaceTest {

    /**
     * Constructor
     * 
     * @param array $configuration
     */
    public function __construct(array $configuration = null);
    
    /**
     * Initialize CommandHandler and EventListener from configuration
     * 
     * @return void
     */
    public function pipe(BusInterfaceTest $bus, array $configuration);
}