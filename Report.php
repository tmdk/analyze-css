<?php


/**
 * Class Report
 */
class Report
{
    /** @var CssSource */
    protected $source;

    /** @var Filter[] */
    public $filters;

    /** @var CssBlock[] */
    public $cssBlocks;

    /** @var array */
    public $classMap;

    /** @var array */
    public $idMap;

    /** @var array */
    public $typeMap;

    function __construct($str)
    {
        $this->source    = CssSource::fromString($str);
        $this->cssBlocks = $this->source->getBlocks();

        $this->filters = $this->loadFilters($this->source);

        $maps           = $this->maps($this->source);
        $this->idMap    = $maps['id'];
        $this->classMap = $maps['class'];
        $this->typeMap  = $maps['type'];

    }

    /**
     * @param CssSource $source
     *
     * @return Filter[]
     */
    protected function loadFilters($source)
    {
        return [
            new RuleTypeFilter($source),
            new IdFilter($source),
            new ClassFilter($source),
        ];
    }


    /**
     * @param CssSource $source
     *
     * @return array
     */
    protected function maps(CssSource $source)
    {
        $map = [];

        foreach ($source->getRootBlock()->walk() as $block) {
            /** @var CssBlock $block */
            foreach ($block->identifiers as $identifier) {
                $map['id'][$identifier][] = $block->id;
            }
            foreach ($block->classes as $class) {
                $map['class'][$class][] = $block->id;
            }

            $type = $block->isAtRule() ? ('@' . $block->getAtRuleType()) : 'qualified';

            $map['type'][$type][] = $block->id;
        }

        return $map;
    }

}