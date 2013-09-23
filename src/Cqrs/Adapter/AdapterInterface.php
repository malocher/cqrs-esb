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
use Cqrs\Gate;

/**
 * AdapterInterface
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
interface AdapterInterface {

    /**
     * Constructor
     */
    public function __construct();
    
    /**
     * Initialize CommandHandler and EventListener from configuration
     * 
     * @return void
     */
    public function initializeBus(BusInterface $bus, array $configuration);
}