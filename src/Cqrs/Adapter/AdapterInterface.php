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
     * implement route
     */
    public function route(BusInterface $bus,$qualifiedClassname);

}