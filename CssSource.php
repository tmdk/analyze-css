<?php


/**
 * Class CssSource
 */
class CssSource
{
    /** @var CssBlock */
    protected $rootBlock;

    /**
     * @param string $str
     *
     * @return CssSource
     *
     */
    static function fromString($str)
    {
        $scanner = new StringScanner($str);

        $rootBlock = CssBlock::root();
        $block     = $rootBlock;
        $blocks    = [$block];
        $prelude   = '';

        $commentOpen  = $scanner->escape('/*');
        $commentClose = $scanner->escape('*/');
        $blockOpen    = $scanner->escape('{');
        $blockClose   = $scanner->escape('}');

        while ($scanner->hasNext()) {

            $scanner->skip('\s+');

            $matches = [];

            if ($scanner->accept($commentOpen)) {

                $scanner->skipUntil($commentClose);
                $scanner->accept($commentClose);

            } elseif ($scanner->accept($blockOpen)) {

                $blocks[] = $block;

                $block = $block->addBlock($prelude);

                $prelude = '';

            } elseif ($scanner->accept($blockClose, $matches)) {

                $block = array_pop($blocks);

            } elseif ($block->isQualifiedRule() && $scanner->acceptUntil($blockClose, $matches)) {

                $block->addRules($matches[0]);

            } else {

                $matches = [];

                if ($scanner->acceptUntil($blockOpen, $matches)) {
                    $prelude = $prelude . $matches[0];
                }

            }

        }

        $instance = new self;

        $instance->rootBlock = $rootBlock;

        return $instance;
    }

    /**
     * @return Generator
     */
    function getBlocks()
    {
        foreach ($this->rootBlock->blocks as $block) {
            yield $block;
        }
    }

    /**
     * @return string[]
     */
    function classes()
    {
        $blocks = collection($this->rootBlock->walk());

        return $blocks->map(function ($block) {
            return $block->classes;
        })->reduce([], function ($combined, $classes) {
            return array_merge($combined, $classes);
        })->get();
    }

    /**
     * @return string[]
     */
    function identifiers()
    {
        $blocks = collection($this->rootBlock->walk());

        return $blocks->map(function ($block) {
            return $block->identifiers;
        })->reduce([], function ($combined, $identifiers) {
            return array_merge($combined, $identifiers);
        })->get();
    }

    /**
     * @return CssBlock
     */
    function getRootBlock()
    {
        return $this->rootBlock;
    }


}