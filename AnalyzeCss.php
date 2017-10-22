<?php

include __DIR__ . '/Collection.php';
include __DIR__ . '/Filter.php';
include __DIR__ . '/RuleTypeFilter.php';
include __DIR__ . '/ClassFilter.php';
include __DIR__ . '/IdFilter.php';
include __DIR__ . '/CssBlock.php';
include __DIR__ . '/CssSource.php';
include __DIR__ . '/FilterOption.php';
include __DIR__ . '/Report.php';
include __DIR__ . '/StringScanner.php';

include __DIR__ . '/functions.php';


/**
 * Class AnalyzeCss
 */
class AnalyzeCss
{

    static function run()
    {
        $file = getenv('ANALYZECSS_FILE');

        if ( ! is_readable($file)) {
            die("$file is not readable");
        }

        $report = new Report(file_get_contents($file));

        echo report($report);
    }

}