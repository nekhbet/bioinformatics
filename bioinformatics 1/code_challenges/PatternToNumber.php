<?php
require(__DIR__.'/../../_common.php');

echo PatternToNumber('AGT');
echo '<hr>';
echo PatternToNumberOptimized('GAATGGAACCATTAATCGTG');
echo '<hr>';
echo NumberToPattern(5437, 8);
echo '<hr>';
echo NumberToPatternOptimized(7551, 7);