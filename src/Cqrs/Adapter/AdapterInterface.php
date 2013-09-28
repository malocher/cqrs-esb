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
use Cqrs\Gate;

/**
 * Interface AdapterInterface
 *
 * @author Manfred Weber <crafics@php.net>
 * @package Cqrs\Adapter
 */
interface AdapterInterface
{

    /**
     * Constructor
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = null);

    /**
     * pipe
     *
     * Initialize CommandHandler and EventListener from configuration
     *
     * @param \Cqrs\Bus\BusInterface $bus
     * @param array $configuration
     * @return void
     */
    public function pipe(BusInterface $bus, array $configuration);
}