<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test1;

use Cqrs\Bus\AbstractBus;

class Test1Bus extends AbstractBus
{
    public function getName()
    {
        return 'test-integration-test1-bus';
    }    
}
