<?php /** @var Report $report */ ?>
<script>
    var report = <?php echo json_encode([
        'classMap' => $report->classMap,
        'idMap'    => $report->idMap,
        'typeMap'  => $report->typeMap
    ]) ?>;
</script>
