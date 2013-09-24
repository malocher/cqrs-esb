<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Integration\Test2;

use Cqrs\Adapter\AdapterTrait;

class Test2Handler
{
    use AdapterTrait;

    /**
     * @Cqrs\Annotation\Command("Test\Integration\Test2\Test2Command")
     * @param Test2Command $command
     */
    public function edit(Test2Command $command)
    {
        if ($command instanceof Test2Command) {
            $command->edit();
        }
        if (is_callable($command->callback)) {
            call_user_func($command->callback,$this,$command,$command->isEdited());
        }
    }
}
