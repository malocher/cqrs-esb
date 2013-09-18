<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dschini\Cqrs\Command;

/**
 * CommandInterfaces
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
interface CommandInterface {
    
    /**
     * Constructor
     * 
     * @param array $arguments
     */
    public function __construct(array $arguments = null);
    
    /**
     * Get arguments of the command as array
     * 
     * @return array List of arguments
     */
    public function getArguments();
}