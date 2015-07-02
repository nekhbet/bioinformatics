<?php
require(__DIR__.'/../../_common.php');

echo implode(' ', FrequentWordsMismatchesBruteForce(
	'TAGC',
	4,
	3,
	TRUE
));