<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Mock\Service;

class MockFooService {

    /**
     * @Cqrs\Annotation\Command("Test\Mock\Command\MockCommand")
     */
    public function getFoo($command)
    {
        var_dump(array(
            'class' => __CLASS__,
            'method' => __METHOD__,
            'command' => $command
        ));
    }
}