<?php


/**
 * Class RuleTypeFilter
 */
class RuleTypeFilter extends Filter
{
    function __construct(CssSource $source)
    {
        $types = array_count_values(collection($source->getRootBlock()->walk())
            ->map(function ($block) {
                /** @var CssBlock $block */
                return $block->isAtRule() ? '@' . $block->getAtRuleType() : 'qualified';
            })
            ->get());

        arsort($types);

        $options = collection($types)
            ->items()
            ->map(function ($pair) {
                list($type, $count) = $pair;

                return new FilterOption([
                    'label' => ucfirst($type),
                    'value' => $type,
                    'count' => $count,
                ]);
            })->get();

        parent::__construct([
            'key'     => 'type',
            'title'   => 'Rule Type',
            'options' => $options,
        ]);
    }

}