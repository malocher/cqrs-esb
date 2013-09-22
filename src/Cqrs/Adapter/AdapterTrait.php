<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Adapter;

use Cqrs\Gate;

/**
 * AnnotationAdapter
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
trait AdapterTrait {
    public function getBus( $name )
    {
        return Gate::getInstance()->getBus( $name );
    }
}