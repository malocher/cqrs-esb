<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <manfred.weber@gmail.com> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Annotation;

/**
 * AnnotationException
 *
 * @author Manfred Weber <manfred.weber@gmail.com>
 */
class AnnotationException extends \Exception
{
    /**
     * Creates a new AnnotationException describing a property error.
     *
     * @param string $message Exception message
     * @return AnnotationException
     */
    public static function propertyError($message)
    {
        return new self('[Property Error] ' . $message . "\n");
    }

}
