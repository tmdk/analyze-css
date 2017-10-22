<?php


/**
 * Class FilterOption
 */
class FilterOption
{

    /**
     * @var string
     */
    public $label;
    /**
     * @var string
     */
    public $value;
    /**
     * @var int
     */
    public $count;

    function __construct($args)
    {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }
    }


}