<?php


/**
 * Class Collection
 */
class Collection
{
    /** @var callable[] */
    protected $stack = [];

    /** @var Traversable */
    protected $collection;

    /**
     * Collection constructor.
     *
     * @param array $collection
     */
    function __construct($collection = [])
    {
        $this->collection = $collection;
    }

    function map($callable)
    {
        $this->stack[] = function ($t) use ($callable) {
            foreach ($t as $k => $v) {
                yield $k => $callable($v);
            }
        };

        return $this;
    }

    function items()
    {
        $this->stack[] = function ($t) {
            foreach ($t as $k => $v) {
                yield [$k, $v];
            }
        };

        return $this;
    }

    function filter($callable)
    {
        $this->stack[] = function ($t) use ($callable) {
            foreach ($t as $k => $v) {
                if ($callable($v)) {
                    yield $k => $v;
                }
            }
        };

        return $this;
    }

    function reduce($initialValue, $callable)
    {
        $this->stack[] = function ($t) use ($initialValue, $callable) {
            $accumulator = $initialValue;

            foreach ($t as $k => $v) {
                $accumulator = $callable($accumulator, $v);
            }

            return $accumulator;
        };

        return $this;
    }

    function unique()
    {
        $this->stack[] = function ($t) {
            $seen = [];

            foreach ($t as $k => $v) {
                if ( ! in_array($v, $seen, true)) {
                    $seen[] = $v;
                    yield $k => $v;
                }
            }

        };

        return $this;

    }

    /**
     * @return array
     */
    function get()
    {
        $collection = $this->collection;

        foreach ($this->stack as $callable) {
            $collection = $callable($collection);
        }

        return is_array($collection) ? $collection : iterator_to_array($collection, false);
    }

}