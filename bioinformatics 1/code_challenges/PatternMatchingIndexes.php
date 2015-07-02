<?php
require(__DIR__.'/../../_common.php');

echo PatternMatchingIndexes(
	'CTTGATCAT',
	file_get_contents(__DIR__.'/../../Vibrio_cholerae.txt')
);