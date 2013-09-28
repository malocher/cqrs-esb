<?php
/*
 * This file is part of the Cqrs package.
 * (c) Manfred Weber <crafics@php.net> and Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cqrs\Annotation;

/**
 * Class Event
 *
 * @Annotation
 * @package Cqrs\Annotation
 * @author Manfred Weber <crafics@php.net>
 */
class Event
{
    /**
     * @var string name of the event
     */
    private $class;

    /**
     * Constructor
     *
     * @throws AnnotationException
     * @param array $options
     */
    public function __construct($options)
    {
        if (isset($options['value'])) {
            $options['class'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw AnnotationException::propertyError(sprintf('Property "%s" does not exist', $value));
            }
            $this->$key = $value;
        }
    }

    /**
     * getClass
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}