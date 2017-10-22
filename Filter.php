<?php


/**
 * Class Filter
 */
abstract class Filter
{
    /**
     * @var FilterOption[]
     */
    public $options;
    /**
     * @var string
     */
    public $key = '';
    /**
     * @var string
     */
    public $title = '';

    function __construct($args = [])
    {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }
    }

}