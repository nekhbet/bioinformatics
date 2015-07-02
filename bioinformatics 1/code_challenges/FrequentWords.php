<?php
require(__DIR__.'/../../_common.php');

echo FrequentWords(
	'CGGAGGACTCTAGGTAACGCTTATCAGGTCCATAGGACATTCA',
	3
);
echo '<hr>';
echo FrequentWordsOptimized(
	'CGGAGGACTCTAGGTAACGCTTATCAGGTCCATAGGACATTCA',
	3
);