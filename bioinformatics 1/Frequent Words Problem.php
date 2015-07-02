<?php
require(__DIR__.'/../_common.php');

// Read input file
$in = get_file_lines('Frequent Words Problem.txt');
$str = $in[0];
$k = $in[1];

echo FrequentWords($str, $k);