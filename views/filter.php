<?php /** @var Filter $filter */ ?>
<section class="filter">
    <h2 class="filter-title"><?php echo $filter->title ?></h2>

    <ul class="filter-options">
        <?php foreach ($filter->options as $option) { ?>
            <li class="filter-option">
                <label for="filter-<?php echo $filter->key ?>-<?php echo $option->value ?>">
                    <input type="checkbox" class="filter-<?php echo $filter->key ?>-input" id="filter-<?php echo $filter->key ?>-<?php echo $option->value ?>"
                           value="<?php echo $option->value ?>">
                    <?php echo "{$option->label} ({$option->count})"; ?>
                </label>
            </li>
        <?php } ?>
    </ul>
</section>
