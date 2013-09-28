<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test\Coverage\Cqrs\Annotation;

/**
 * AnnotationExceptionTest
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class AnnotationExceptionTest extends \Exception
{
    /**
     * Creates a new AnnotationExceptionTest describing a property error.
     *
     * @param string $message Exception message
     * @return AnnotationExceptionTest
     */
    public static function propertyError($message)
    {
        return new self('[Property Error] ' . $message . "\n");
    }

}
