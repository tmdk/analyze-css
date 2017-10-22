<?php


/**
 * Class IdFilter
 */
class IdFilter extends Filter
{

    function __construct(CssSource $source)
    {
        $identifiers = array_count_values($source->identifiers());

        arsort($identifiers);

        $options = collection($identifiers)
            ->items()
            ->map(function ($pair) {
                list($id, $count) = $pair;

                return new FilterOption([
                    'label' => $id,
                    'value' => $id,
                    'count' => $count,
                ]);
            })->get();

        parent::__construct([
            'key'     => 'id',
            'title'   => 'Element ID',
            'options' => $options,
        ]);
    }

}