<?php

include('../AnagramFinder.php');

$phrase = "water bottle";

$min_word_size = 4;

$anagrams = AnagramFinder::findAnagramsOfPhrase($phrase, $min_word_size);


//Testing that all output is valid
$alphaPhrase = str_split(str_replace(" ", "", $phrase));
sort($alphaPhrase);
$alphaPhrase = join('', $alphaPhrase);
$valid = 1;

for($i=0; $i<sizeof($anagrams); $i++) {
	$sorted = str_split(str_replace(" ", "", $anagrams[$i]));
	sort($sorted);
	$sorted = join('', $sorted);
	if($sorted != $alphaPhrase) {
		$valid = 0;
		echo "ALERT: " . $anagrams[$i] . " is not really an anagram.\n";
	}
}

if($valid == 1) {
	echo "Test was successful. All produced anagrams were actually anagrams.\n\n";
} else if($valid == 0) {
	echo "Test was unsuccessful. Review cases above.\n\n";
}