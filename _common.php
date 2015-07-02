<?php

// 31 red
// 32 green
// 33 orange
// 34 blue
function debug_data($text, $color = '')
{
	switch ($color)
	{
		case 'red': $color = 31; break;
		case 'green': $color = 32; break;
		case 'orange': $color = 33; break;
		case 'blue': $color = 34; break;
	}
	if ($color)
	{
		echo "\033[".$color."m";
	}
	echo $text."\n";
	if ($color)
	{
		echo "\033[0m";
	}
	flush();
	// ob_flush();
}

function ddd($array, $die = TRUE)
{
	print '<pre>';
	print_r($array);
	print '</pre>';
	if ($die) die();
}

function get_file_lines($file)
{
	$in = trim(file_get_contents($file));
	$in = explode("\n", $in);
	$out = array();
	foreach ($in as $_line)
	{
		if (trim($_line) !== '')
		{
			$out[] = $_line;
		}
	}
	return $out;
}

function substr_count_overlapping($str, $substring)
{
	$cnt = $offset = 0;
	while (stripos($str, $substring, $offset) !== FALSE AND $offset !== FALSE)
	{
		$cnt++;
		$offset = stripos($str, $substring, $offset) + 1;
	}
	return $cnt;
}

function FrequentWords($str, $k)
{
	// Split it in substrings
	if ($k > strlen($str))
	{
		return '';
	}
	$sets = array();
	for ($i = 0; $i <= strlen($str) - $k; $i++)
	{
		$key = substr($str, $i, $k);
		$sets[$key] = $key;
	}

	// Which is the best?
	$max = 0;
	foreach ($sets as $key => $set)
	{
		$sets[$key] = PatternCount($str, $key);
		$max = max($sets[$key], $max);
	}

	// Display solution, space separated
	$solution = array();
	foreach ($sets as $key => $set)
	{
		if ($set == $max)
		{
			$solution[] = $key;
		}
	}
	return implode(' ', $solution);
}

function FrequentWordsBySorting($str, $k)
{
	// Split it in substrings
	if ($k > strlen($str))
	{
		return '';
	}
	$values = array();
	$times = array();
	for ($i = 0; $i <= strlen($str) - $k; $i++)
	{
		$key = PatternToNumber(substr($str, $i, $k));
		$values[] = $key;
		if (isset($times[$key]))
		{
			$times[$key]++;
		}
		else
		{
			$times[$key] = 1;
		}
	}

	$solution = array_keys($times, max($times));
	$values = array();
	foreach ($solution as $_solution)
	{
		$values[] = NumberToPatternOptimized($_solution, $k);
	}
	return implode(' ', $values);
}

function SymbolToNumber($symbol)
{
	switch ($symbol)
	{
		case 'A': return 0;
		case 'C': return 1;
		case 'G': return 2;
		case 'T': return 3;
	}
}

function NumberToSymbol($number)
{
	switch ($number)
	{
		case 0: return 'A';
		case 1: return 'C';
		case 2: return 'G';
		case 3: return 'T';
	}
}

function ComputingFrequencies($text, $k)
{
	/*for i ← 0 to 4k − 1
            FrequencyArray(i) ← 0
        for i ← 0 to |Text| − k
            Pattern ← Text(i, k)
            j ← PatternToNumber(Pattern)
            FrequencyArray(j) ← FrequencyArray(j) + 1
        return FrequencyArray*/
	$limit = pow(4, $k);
	$_len = strlen($text);
	$results = array();
	for ($i = 0; $i <= $limit - 1; $i++)
	{
		$results[$i] = 0;
	}
	for ($i = 0; $i <= $_len - $k; $i++)
	{
		$pattern = substr($text, $i, $k);
		$j = PatternToNumberOptimized($pattern);
		//echo $pattern.'--'.$j;
		$results[$j] = $results[$j] + 1;
		//echo '<hr>';
	}
	return $results;
}

function PatternToNumberOptimized($pattern)
{
	if (strlen($pattern) == 0)
	{
		return 0;
	}
	$symbol = $pattern[strlen($pattern) - 1];
	$pattern = substr($pattern, 0, -1);
	return 4 * PatternToNumberOptimized($pattern) + SymbolToNumber($symbol);
}

function PatternToNumber($pattern)
{
	$k = strlen($pattern);
	$chars = array('A', 'C', 'G', 'T');
	$output = sampling_cached($chars, $k);
	return array_search($pattern, $output);
}

function NumberToPatternOptimizedBinary($key, $size)
{
	$pattern = array();
	while ($key > 0)
	{
		$rest = $key % 2;
		$key = floor($key / 2);
		//$rest2 = $key
		$pattern[] = $rest;
	}
	while (count($pattern) != $size)
	{
		$pattern[] = '0';
	}
	//ddd($pattern);
	return strrev(implode('', $pattern));
}

function NumberToPatternOptimized($key, $size)
{
	$pattern = array();
	while ($key > 0)
	{
		$rest = $key % 4;
		$key = floor($key / 4);
		//$rest2 = $key
		$pattern[] = NumberToSymbol($rest);
	}
	while (count($pattern) != $size)
	{
		$pattern[] = 'A';
	}
	//ddd($pattern);
	return strrev(implode('', $pattern));
}

function NumberToPattern($key, $size)
{
	$chars = array('A', 'C', 'G', 'T');
	$output = sampling_cached($chars, $size);
	return $output[$key];
}

function sampling_cached($chars, $size)
{
	$path = '/tmp/php.sampling_cached.'.md5(serialize($chars)).'.'.$size;
	if (file_exists($path))
	{
		$data = file_get_contents($path);
		return unserialize($data);
	}
	$data = sampling($chars, $size);
	file_put_contents($path, serialize($data));
	return $data;
}

function sampling($chars, $size, $combinations = array()) {

	# if it's the first iteration, the first set
	# of combinations is the same as the set of characters
	if (empty($combinations)) {
		$combinations = $chars;
	}

	# we're done if we're at size 1
	if ($size == 1) {
		return $combinations;
	}

	# initialise array to put new values in
	$new_combinations = array();

	# loop through existing combinations and character set to create strings
	foreach ($combinations as $combination) {
		foreach ($chars as $char) {
			$new_combinations[] = $combination . $char;
		}
	}

	# call same function again for the next iteration
	return sampling($chars, $size - 1, $new_combinations);
}


function FrequentWordsOptimized($str, $k)
{
	/*
	 * FrequentPatterns ← an empty set
        FrequencyArray ← ComputingFrequencies(Text, k)
        maxCount ← maximal value in FrequencyArray
        for i ←0 to 4k − 1
            if FrequencyArray(i) = maxCount
                Pattern ← NumberToPattern(i, k)
                add Pattern to the set FrequentPatterns
        return FrequentPatterns
	 */
	$fpatterns = array();
	$farray = ComputingFrequencies($str, $k);
	$maxCount = max($farray);
	$_limit_for = pow(4, $k) - 1;
	for ($i = 0; $i <= $_limit_for; $i++)
	{
		if ($farray[$i] == $maxCount)
		{
			$fpatterns[] = NumberToPatternOptimized($i, $k);
		}
	}
	return implode(' ', array_unique($fpatterns));
}

function ReverseComplement($str)
{
	return strrev(strtr($str, array(
		'A' => 'T',
		'T' => 'A',
		'C' => 'G',
		'G' => 'C',
	)));
}

function PatternMatchingIndexes($pattern, $genome)
{
	$cnt = $offset = 0;
	$indexes = array();
	while (stripos($genome, $pattern, $offset) !== FALSE AND $offset !== FALSE)
	{
		$cnt++;
		$indexes[] = stripos($genome, $pattern, $offset);
		$offset = stripos($genome, $pattern, $offset) + 1;
	}
	return implode(' ', $indexes);
}

function ClumpFinding($genome, $kmer, $Length, $times)
{
	// 1. Get all our k-mers from the genome
	$kmers = explode(' ', FrequentWords($genome, $kmer));
	if ($kmers)
	{
		$solution = array();
		// Check each one of them
		$_strlen = strlen($genome);
		//ddd($kmers);
		foreach ($kmers as $_item)
		{
			//echo strpos($genome, $_item).'<br>';
			//echo $_strlen.'<br>';
			//die();
			// Is it a solution?
			for ($i = strpos($genome, $_item); $i <= $_strlen; $i++)
			{
				// echo $i.'<br>';
				//die('ffg');
				$_text = substr($genome, $i, $Length);
				//echo $_text.'<br>';
				if (PatternCount($_text, $_item) >= $times)
				{
					$solution[] = $_item;
					//ddd($solution);
					break;
				}
			}
		}

		return implode(' ', $solution);
	}
	return '';
}

function ClumpFindingOptimized($genome, $k, $Length, $times)
{
	/*
	 *
	 BetterClumpFinding(Genome, k, t, L)
        FrequentPatterns ← an empty set
        for i ←0 to 4k − 1
            Clump(i) ← 0
        Text ← Genome(0, L)
        FrequencyArray ← ComputingFrequencies(Text, k)
        for i ← 0 to 4k − 1
            if FrequencyArray(i) ≥ t
                Clump(i) ← 1
        for i ← 1 to |Genome| − L
            FirstPattern ← Genome(i − 1, k)
            j ← PatternToNumber(FirstPattern)
            FrequencyArray(j) ← FrequencyArray(j) − 1
            LastPattern ← Genome(i + L − k, k)
            j ← PatternToNumber(LastPattern)
            FrequencyArray(j) ← FrequencyArray(j) + 1
            if FrequencyArray(j) ≥ t
                Clump(j) ← 1
        for i ← 0 to 4k − 1
            if Clump(i) = 1
                Pattern ← NumberToPattern(i, k)
                add Pattern to the set FrequentPatterns
        return FrequentPatterns
	 */
	$FrequentPatterns = array();
	$Clump = array();
	$_limit = pow(4, $k) - 1;
	for ($i = 0; $i <= $_limit; $i++)
	{
		$Clump[$i] = 0;
	}

	$Text = substr($genome, 0, $Length);
	$FrequencyArray = ComputingFrequencies($Text, $k);
	for ($j = 0; $j <= $_limit; $j++)
	{
		if ($FrequencyArray[$j] >= $times)
		{
			$Clump[$j] = 1;
		}
	}
	$_limit_for_i = strlen($genome) - $Length;
	for ($i = 1; $i <= $_limit_for_i; $i++)
	{
		$FirstPattern = substr($genome, $i - 1, $k);
		$j = PatternToNumberOptimized($FirstPattern);
		$FrequencyArray[$j]--;
		$LastPattern = substr($genome, $i + $Length - $k, $k);
		$j = PatternToNumberOptimized($LastPattern);
		$FrequencyArray[$j]++;
		if ($FrequencyArray[$j] >= $times)
		{
			$Clump[$j] = 1;
		}
	}

	for ($i = 0; $i <= $_limit; $i++)
	{
		if ($Clump[$i] == 1)
		{
			$Pattern = NumberToPatternOptimized($i, $k);
			$FrequentPatterns[] = $Pattern;
		}
	}

	return $FrequentPatterns;
}

function ApproximatePatternMatching($pattern, $genome, $max_hamming_distance)
{
	$k = strlen($pattern);
	$indexes = array();
	for ($i = 0; $i <= strlen($genome) - $k; $i++)
	{
		$_text = substr($genome, $i, $k);
		if (HammingDistance($pattern, $_text) <= $max_hamming_distance)
		{
			$indexes[] = $i;
		}
	}
	return $indexes;
}

function CountX($x, $genome, $pattern)
{
	return count(ApproximatePatternMatching($pattern, $genome, $x));
}

function ProbabilitiesPatternsString($k, $alphabet_of_A_letters, $Pattern, $times)
{
	// Pr(4, 2, 01, 1) = 11/16 while Pr(4, 2, 11, 1) = 1/2
	// Generate all values
	$limit = pow($alphabet_of_A_letters, $k);
	$ok = 0;
	for ($i = 0; $i < $limit; $i++)
	{
		$j = NumberToPatternOptimizedBinary($i, $k);

		// Is it a solution or not?
		if (PatternCount($j, $Pattern) >= $times)
		{
			$ok++;
		}
		// echo $j.'-'.PatternCount($j, $Pattern).'<br>';
		// $results[$j] = $results[$j] + 1;
		//echo '<hr>';
	}

	echo $ok.'--';

	return 1.0 * ( $ok / $limit);
}

function ImmediateNeighbors($Pattern)
{
	/*
	 *  Neighborhood ← set consisting of single string Pattern
        for i = 1 to |Pattern|
            symbol ← i-th nucleotide of Pattern
            for each nucleotide x different from symbol
                Neighbor ← Pattern with the i-th nucleotide substituted by x
                add Neighbor to Neighborhood
        return Neighborhood
	 */
	$Neighborhood = array();
	for ($i = 0; $i < strlen($Pattern); $i++)
	{
		$symbol = $Pattern[$i];
		$nucleotides = array(
			'A' => 'A',
			'C' => 'C',
			'G' => 'G',
			'T' => 'T',
		);
		unset($nucleotides[$symbol]);
		foreach ($nucleotides as $_nucleotide)
		{
			$Neighbor = $Pattern;
			$Neighbor[$i] = $_nucleotide;
			$Neighborhood[] = $Neighbor;
		}
	}
	return $Neighborhood;
}

function GenerateAllKMers($genome, $k)
{
	$kmers = array();
	for ($i = 0; $i <= strlen($genome) - $k; $i++)
	{
		$kmers[] = substr($genome, $i, $k);
	}
	return array_unique($kmers);
}

function _prepare_genome_file($in)
{
	file_put_contents($in, str_replace(array("\r", "\n"), '', file_get_contents($in)));
}

function MotifEnumeration($dna_kmers, $k, $d)
{
	/*
	 *  Patterns ← an empty set
        for each k-mer Pattern in Dna
            for each k-mer Pattern’ differing from Pattern by at most d mismatches
                if Pattern' appears in each string from Dna with at most d mismatches
                    add Pattern' to Patterns
        remove duplicates from Patterns
        return Patterns
	*/
	$Patterns = array();
	foreach ($dna_kmers as $Pattern)
	{
		$kmers_prime = GenerateAllKMers($Pattern, $k);
		foreach ($kmers_prime as $Pattern_prime_x)
		{
			//ddd($Pattern_prime_x, FALSE);
			$Neighbours = Neighbors($Pattern_prime_x, $d);
			foreach ($Neighbours as $Pattern_prime)
			{
				//ddd($Neighbours);
				$score = 0;
				foreach ($dna_kmers as $Pattern_for_count)
				{
					if (ApproximatePatternCount($Pattern_for_count, $Pattern_prime, $d) > 0)
					{
						$score++;
					}
				}
				if ($score == count($dna_kmers))
				{
					$Patterns[] = $Pattern_prime;
				}
			}
		}
	}
	return array_unique($Patterns);
}

function Neighbors($Pattern, $d)
{
	/*
	 *  Neighbors(Pattern, d)
			if d = 0
				return {Pattern}
			if |Pattern| = 1
				return {A, C, G, T}
			Neighborhood ← an empty set
			SuffixNeighbors ← Neighbors(Suffix(Pattern), d)
			for each string Text from SuffixNeighbors
				if HammingDistance(Suffix(Pattern), Text) < d
					for each nucleotide x
						add x • Text to Neighborhood
				else
					add FirstSymbol(Pattern) • Text to Neighborhood
			return Neighborhood
	 */
	if ($d == 0)
	{
		return $Pattern;
	}
	$nucleotides = array(
		'A' => 'A',
		'C' => 'C',
		'G' => 'G',
		'T' => 'T',
	);
	if (strlen($Pattern) == 1)
	{
		return $nucleotides;
	}
	$Neighborhood = array();
	$Suffix = substr($Pattern, 1);
	$Prefix = substr($Pattern, 0, 1);
	$SuffixNeighbors = Neighbors($Suffix, $d);
	foreach ($SuffixNeighbors as $Text)
	{
		if (HammingDistance($Suffix, $Text) < $d)
		{
			foreach ($nucleotides as $x)
			{
				$Neighborhood[] = $x.$Text;
			}
		}
		else
		{
			$Neighborhood[] = $Prefix.$Text;
		}
	}
	return $Neighborhood;
}

function FrequentWordsWithMismatchesAndReverseComplements($genome, $k, $d, $debug = FALSE)
{
	$solution = array();
	$_max = -1;
	$_length = pow(4, $k);
	for ($i = 0; $i < $_length; $i++)
	{
		$_text = NumberToPatternOptimized($i, $k);
		$_indexes = ApproximatePatternMatching($_text, $genome, $d);

		$_complement = ReverseComplement($_text);
		$_indexes2 = ApproximatePatternMatching($_complement, $genome, $d);

		if ($_indexes OR $_indexes2)
		{
			$_cnt = count($_indexes) + count($_indexes2);
			if ($_cnt > $_max)
			{
				$solution = array();
				$solution[$_text] = $_text;
				$_max = $_cnt;
			}
			elseif ($_cnt == $_max)
			{
				$solution[$_text] = $_text;
			}
		}
		if ($debug AND $i % 10000 == 0)
		{
			debug_data('I = '.$i.'/'.$_length);
		}
	}
	return $solution;
}

function FrequentWordsMismatchesBruteForce($genome, $k, $d, $debug = FALSE)
{
	$solution = array();
	$_max = -1;
	$_length = pow(4, $k);
	for ($i = 0; $i < $_length; $i++)
	{
		$_text = NumberToPatternOptimized($i, $k);
		$_indexes = ApproximatePatternMatching($_text, $genome, $d);
		if ($_indexes)
		{
			$_cnt = count($_indexes);
			if ($_cnt > $_max)
			{
				$solution = array();
				$solution[$_text] = $_text;
				$_max = $_cnt;
			}
			elseif ($_cnt == $_max)
			{
				$solution[$_text] = $_text;
			}
		}
		if ($debug AND $i % 10000 == 0)
		{
			debug_data('I = '.$i.'/'.$_length);
		}
	}
	return $solution;
}

function FrequentWordsMismatches($genome, $k, $d)
{
	// Does find only patterns in the TEXT!!!!!
	$solution = array();
	$_max = -1;
	for ($i = 0; $i <= strlen($genome) - $k; $i++)
	{
		$_text = substr($genome, $i, $k);
		$_indexes = ApproximatePatternMatching($_text, $genome, $d);
		if ($_indexes)
		{
			$_cnt = count($_indexes);
			if ($_cnt > $_max)
			{
				$solution = array();
				$solution[$_text] = $_text;
				$_max = $_cnt;
			}
			elseif ($_cnt == $_max)
			{
				$solution[$_text] = $_text;
			}
			// echo $_max.'<hr>';
		}
	}
	return $solution;
}


function MinimumSkewProblem($genome)
{
	$diagram = SkewDiagram($genome);
	return array_keys($diagram, min($diagram));
}

function MaximumSkewProblem($genome)
{
	$diagram = SkewDiagram($genome);
	//ddd($diagram);
	return array_keys($diagram, max($diagram));
}

function SkewDiagram($genome)
{
	$diagram = array(0);
	$_length = strlen($genome);
	for ($i = 0; $i < $_length; $i++)
	{
		if ($genome[$i] == 'G')
		{
			$diagram[$i+1] = $diagram[$i] + 1;
		}
		elseif ($genome[$i] == 'C')
		{
			$diagram[$i+1] = $diagram[$i] - 1;
		}
		else
		{
			$diagram[$i+1] = $diagram[$i];
		}
	}
	return $diagram;
	// If this nucleotide is G, then Skewi+1(Genome) = Skewi(Genome) + 1; if this nucleotide is C, then Skewi+1(Genome)= Skewi(Genome) – 1; otherwise, Skewi+1(Genome) = Skewi(Genome).
}

function ApproximatePatternCount($genome, $pattern, $max_hamming_distance)
{
	return count(ApproximatePatternMatching($pattern, $genome, $max_hamming_distance));
}

function HammingDistance($str1, $str2)
{
	$distance = 0;
	for ($i = 0; $i < strlen($str1); $i++)
	{
		if ($str1[$i] != $str2[$i])
		{
			$distance++;
		}
	}
	return $distance;
}


/* ALIASES */
function PatternCount($str, $substring)
{
	return substr_count_overlapping($str, $substring);
}