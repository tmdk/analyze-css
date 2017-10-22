<?php /** @var Report $report */ ?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    <script src="https://use.fontawesome.com/bcafa186c4.js"></script>

    <?php echo reportJson($report); ?>
</head>
<body>

<?php echo filters($report->filters) ?>

<section class="css-blocks">
    <?php foreach ($report->cssBlocks as $cssBlock) { ?>

        <?php echo cssBlock($cssBlock) ?>

    <?php } ?>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="js/main.js"></script>
</body>
</html>
