<?php

include("./AnagramFinder.php");

if(isset($argv[1]) && isset($argv[2])) {
	$phrase = $argv[1];
	$min_word_size = $argv[2];

	echo "Finding anagrams for phrase: " . $phrase . "\n";

	$anagrams = AnagramFinder::findAnagramsOfPhrase($phrase, $min_word_size);

	$outfile = fopen('./AnagramOutput.txt', 'w');

	for($i=0; $i<sizeof($anagrams); $i++) {
		fwrite($outfile, $anagrams[$i] . "\n");
	}
	echo "Anagrams for " . $phrase . " have been stored in AnagramOutput.txt\n\n";

	fclose($outfile);
} else {
	echo "Correct usage: \n\tphp Anagram.php [phrase] [minimum word size]\n\n";
}