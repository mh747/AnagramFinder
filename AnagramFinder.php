<?php

class AnagramFinder {
	private $wordList;
	private $validWords;
	private $phrase;
	private $min_word_size;
	private $totalAnagrams;

	public function __construct($phrase, $min_word_size) {
		echo "Getting word list\n";
		$this->wordList = $this->getWordList();
		$this->phrase = $phrase;
		$this->validWords = $this->getValidWords($this->phrase, $this->wordList);
		$this->min_word_size = $min_word_size;
		$this->totalAnagrams = 0;
	}
	
	public static function findAnagramsOfPhrase($phrase, $min_word_size=4) {
		$phrase = str_replace(" ", "", $phrase);
		$phrase = str_split($phrase);

		$anagramFinder = new self($phrase, $min_word_size);
		$anagrams = $anagramFinder->findAnagrams();

		return $anagrams;
	}

	private function getWordList() {
		$wordList = array();
		$wordListFile = fopen('./wordlist', 'r');
		while(!feof($wordListFile)) {
		    $word = str_replace("'", "", rtrim(fgets($wordListFile)));
		    $wordList[] = $word;
		}
		echo "Word list has " . sizeof($wordList) . " words...\n";
		return $wordList;
	}

	private function getValidWords($phrase, $wordList) {
	    $numWords = sizeof($wordList);
	    $validWords = array();
	    for($i=0; $i<$numWords; $i++) {
	        $valid = 1;
	        $letters = array();
	        $word = str_split($wordList[$i]);
	        for($j=0; $j<sizeof($phrase); $j++) {
	            $letters[] = $phrase[$j];
	        }

	        for($j=0; $j<sizeof($word); $j++) {
	            $pos = array_search($word[$j], $letters);
	            if($pos === false) {
	                $valid = 0;
	            } else {
	                array_splice($letters, $pos, 1);
	            }
	        }

	        if($valid == 1) {
				$sortWord = $wordList[$i];
				$sortWord = str_split($sortWord);
				sort($sortWord);
				$sortWord = join('', $sortWord);
				if(array_key_exists($sortWord, $validWords)) {
					$validWords[$sortWord][] = $wordList[$i];
				} else {
					$commonWords = array();
					$commonWords[] = $wordList[$i];
					$validWords[$sortWord] = $commonWords;
				}
	        }
	    }

	    ksort($validWords);
	    echo "But only " . sizeof($validWords) . " valid alphabetically ordered keys. Now checking for anagrams...\n\n";
	    return $validWords;
	}

	private function findAnagrams() {
		$results = array();
		foreach($this->validWords as $key => $value) {
			$newPhrase = $this->getNewLetters($this->phrase, $key);
			$newHash = $this->getNewWords($newPhrase, $this->validWords);
			if(strlen($key) >= $this->min_word_size) {
				for($i=0; $i<sizeof($value); $i++) {
					$this->completeAnagram($newPhrase, $newHash, $value[$i],strlen($value[$i]), sizeof($newPhrase), $results);
				}
			}
		}

		echo "\n\n";

		return $results;
	}

	private function completeAnagram($phrase, $hashMap, $currStr, $currLen, $maxLen, &$results) {
		if(sizeof($phrase) > 0) {
			$phraseStr = join('', $phrase);

			foreach($hashMap as $key=>$value) {
				if(strlen($key) >= $this->min_word_size && strlen($key) <= $maxLen && $this->isValidKey($phrase, $key)) {
					$newPhrase = $this->getNewLetters($phrase, $key);
					$newHash = $this->getNewWords($newPhrase, $hashMap);
					$newMax = $maxLen - strlen($key);
					
					for($i=0; $i<sizeof($value); $i++) {
						$newStr = $currStr . ' ' . $value[$i];
						$newLen = $currLen + strlen($value[$i]);
						$this->completeAnagram($newPhrase, $newHash, $newStr, $newLen, $newMax, $results);
					}
				}
			}
		} else {
			if($currLen == sizeof($this->phrase)) {
				$this->totalAnagrams++;
				echo "     Anagrams found: " . $this->totalAnagrams . " Anagram: " . $currStr . "     \r";
				$results[] = $currStr;
				}
			}
		return;
	}

	private function getNewLetters($phrase, $word) {
		$word = str_split($word);
		$letters = array();

		for($i=0; $i<sizeof($phrase); $i++) {
			$pos = array_search($phrase[$i], $word);
			if($pos === false || $pos === NULL || sizeof($word) == 0) {
				$letters[] = $phrase[$i];
			} else {
				array_splice($word, $pos, 1);
			}
		}

		return $letters;
	}

	function getNewWords($phrase, $wordHash) {
		$newHash = array();
		$numWords = sizeof($wordHash);

		foreach($wordHash as $key=>$value) {
			$valid = 1;
			$keyArr = str_split($key);
			if(sizeof($keyArr) > sizeof($phrase)) {
				$valid = 0;
			}
			for($i=0; $i<sizeof($keyArr); $i++) {
				$pos = array_search($keyArr[$i], $phrase);
				if($pos === false) {
					$valid = 0;
				}
			}

			if($valid == 1) {
				$newHash[$key] = $value;
			}
		}

		return $newHash;
	}

	private function isValidKey($phrase, $key) {
		$key = str_split($key);
		$valid = 1;
		for($i=0; $i<sizeof($key); $i++) {
			$pos = array_search($key[$i], $phrase);
			if($pos === false || $pos === NULL) {
				$valid = 0;
			}
		}
		if(sizeof($key) > sizeof($phrase)) {
			$valid = 0;
		}

		return $valid;
	}
}
