<?php
require(__DIR__.'/../_common.php');

// Read input file
$in = get_file_lines('Reverse Complement Problem.txt');
$str = $in[0];

// Which is the best?
echo ReverseComplement($str);