<?php
require(__DIR__.'/../../_common.php');

echo implode(' ', ApproximatePatternMatching(
	'AAAAA',
	'AACAAGCTGATAAACATTTAAAGAG',
	1
));