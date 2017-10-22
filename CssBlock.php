<?php

class CssBlock
{
    /**
     * @var int
     */
    protected static $instanceCount = 0;

    /**
     * @var bool
     */
    public $isRoot = false;
    /**
     * @var CssBlock[]
     */
    public $blocks = [];
    /**
     * @var string
     */
    public $prelude = '';
    /**
     * @var string[]
     */
    public $rules = [];
    /**
     * @var string
     */
    public $type;
    /**
     * @var string[]
     */
    public $identifiers = [];
    /**
     * @var string[]
     */
    public $classes = [];
    /**
     * @var int
     */
    public $id;

    /**
     * CssBlock constructor.
     *
     * @param string $prelude
     * @param bool $root
     */
    function __construct($prelude, $root = false)
    {
        $prelude           = preg_replace('/\s+/sm', ' ', $prelude);
        $this->prelude     = trim($prelude);
        $this->isRoot      = $root;
        $this->type        = $this->getType();
        $this->identifiers = $this->identifiers();
        $this->classes     = $this->classes();
        $this->id          = self::$instanceCount++;
    }

    /**
     * @return CssBlock
     */
    static function root()
    {
        return new self('@media all', true);
    }

    /**
     * @param string $prelude
     *
     * @return CssBlock
     */
    function addBlock($prelude)
    {
        $block = new CssBlock($prelude);

        $this->blocks[] = $block;

        return $block;
    }

    /**
     * @param string $rules
     */
    function addRules($rules)
    {
        $split       = explode(';', $rules);
        $trimmed     = array_map('trim', $split);
        $this->rules = array_merge($this->rules, $trimmed);
    }

    /**
     * @return bool
     */
    function isAtRule()
    {
        return strlen($this->prelude) && $this->prelude[0] === '@';
    }

    /**
     * @return bool
     */
    function isQualifiedRule()
    {
        return ! $this->isAtRule();
    }

    /**
     * @return bool|string
     */
    function getAtRuleType()
    {
        if ( ! $this->isAtRule()) {
            return false;
        }

        $parts = explode(' ', $this->prelude);

        return substr($parts[0], 1);
    }

    /**
     * @return Generator
     */
    function walk()
    {
        foreach ($this->blocks as $block) {
            yield from $block->walk();
        }

        yield $this;
    }

    /**
     * @return string
     */
    function getType()
    {
        return $this->isAtRule() ? 'at-rule' : 'qualified-rule';
    }

    /**
     * return array
     */
    function classes()
    {
        $regex   = "/\.{$this->identRegex()}/";
        $classes = [];

        if (preg_match_all($regex, $this->prelude, $matches)) {
            foreach ($matches[0] as $class) {
                $classes[] = ltrim($class, '.');
            }
        }

        return $classes;
    }

    /**
     * return array
     */
    function identifiers()
    {
        $regex = "/\#{$this->identRegex()}/";

        $identifiers = [];

        if (preg_match_all($regex, $this->prelude, $matches)) {
            foreach ($matches[0] as $identifier) {
                $identifiers[] = ltrim($identifier, '#');
            }
        }

        return $identifiers;
    }

    /**
     * @return string
     */
    protected function identRegex()
    {
        static $ident = null;

        if ($ident === null) {
            $h        = "[0-9a-f]";
            $unicode  = str_replace("{h}", $h, "\{h}{1,6}(?:\r\n|[ \t\r\n\f])?");
            $escape   = str_replace("{unicode}", $unicode, "(?:{unicode}|\[^\r\n\f0-9a-f])");
            $nonascii = "[\240-\377]";
            $nmchar   = str_replace(array("{nonascii}", "{escape}"), array(
                $nonascii,
                $escape
            ), "(?:[_a-z0-9-]|{nonascii}|{escape})");
            $nmstart  = str_replace(array("{nonascii}", "{escape}"), array(
                $nonascii,
                $escape
            ), "(?:[_a-z]|{nonascii}|{escape})");
            $ident    = str_replace(array("{nmstart}", "{nmchar}"), array(
                $nmstart,
                $nmchar
            ), "-?{nmstart}{nmchar}*");
        }

        return $ident;
    }

}
