<?php


/**
 * Class ClassFilter
 */
class ClassFilter extends Filter
{

    function __construct(CssSource $source)
    {
        $classes = array_count_values($source->classes());

        arsort($classes);

        $options = collection($classes)
            ->items()
            ->map(function ($pair) {
                list($class, $count) = $pair;

                return new FilterOption([
                    'label' => $class,
                    'value' => $class,
                    'count' => $count,
                ]);
            })->get();

        parent::__construct([
            'key'     => 'class',
            'title'   => 'Element Class',
            'options' => $options,
        ]);
    }

}