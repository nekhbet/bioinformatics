<?php
require(__DIR__.'/../../_common.php');

echo implode("\n", Neighbors(
	'CCGGATGATAGT', 2
));