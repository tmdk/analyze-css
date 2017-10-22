<?php
/**
 * @var CssBlock $cssBlock
 */

$class = array_filter([
    'css-block',
    $cssBlock->type,
    $cssBlock->blocks ? 'css-block-collapsable' : false
]);

$id = "css-block-{$cssBlock->id}";

?>
<section class="<?php echo implode(' ', $class) ?>" id="<?php echo $id ?>">
    <h2 class="css-block-prelude"><?php echo $cssBlock->prelude ?></h2>

    <?php foreach ($cssBlock->blocks as $block) {
        echo cssBlock($block);
    } ?>
</section>
