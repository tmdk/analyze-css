<?php /** @var Filter[] $filters */ ?>
<aside class="filters">

	<h1 class="filters-title">Filter</h1>

	<?php foreach ( $filters as $filter ) {
		echo filter( $filter );
	} ?>

</aside>
