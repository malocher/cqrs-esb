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
 * @Annotation
 */
class Event {

    /**
     * @var string name of the event
     */
    private $class;

    /**
     * Constructor
     *
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
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }
            $this->$key = $value;
        }
    }

    /**
     * getClass
     *
     * @return string
     */
    public function getClass(){
        return $this->class;
    }
}