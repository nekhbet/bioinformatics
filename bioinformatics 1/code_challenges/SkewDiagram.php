<?php
require(__DIR__.'/../../_common.php');

_prepare_genome_file('../../Salmonella_enterica.txt');

echo implode(' ', SkewDiagram(
	//'GATACACTTCCCAGTAGGTACTG'
	file_get_contents('../../Salmonella_enterica.txt')
));