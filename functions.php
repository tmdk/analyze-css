<?php

/**
 * @param string $view
 * @param array $params
 *
 * @return string
 */
function render($view, $params)
{
    extract($params);

    ob_start();

    include __DIR__ . "/views/$view.php";

    return ob_get_clean();
}

function report(Report $report)
{
    return render('report', compact('report'));
}

function filter(Filter $filter)
{
    return render('filter', compact('filter'));
}

function cssBlock(CssBlock $cssBlock)
{
    return render('css-block', compact('cssBlock'));
}

function filters(array $filters)
{
    return render('filters', compact('filters'));
}

function reportJson(Report $report)
{
    return render('report-json', compact('report'));
}

/**
 * @param $collection
 *
 * @return Collection
 */
function collection($collection = [])
{
    return new Collection($collection);
}
