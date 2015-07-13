# AnagramFinder
Finds all english-word anagrams of a given phrase. Phrase can be multi word, and output is multi word, but not necessarily the same number of words as input.

## To run:

Clone the repository
```
git clone https://github.com/mh747/AnagramFinder.git
```

Navigate to directory in command line terminal. Then run:

```
php Anagram.php [phrase] [minimum word size]
```

Since the output could contain very many anagrams based on the input, I've decided to have it stored in a file instead of output to the screen line by line. So, when the program finishes, it will place all of the anagrams into AnagramOutput.txt.

## Using the AnagramFinder class

If you'd like to use the AnagramFinder class in your own application, it's simple to use. All you'd need to do is include the AnagramFinder.php file in your code, and then use a statement similar to the following:

```
$results = AnagramFinder::findAnagramsOfPhrase($phrase, $min_word_size);
```
Where, results is an array of all the anagrams, phrase is the original multi-word phrase, and min_word_size is the minimum size of the words produced in the output. min_word_size defaults to 4, and please note, if you make it smaller than that, the script tends to produce large amounts of anagrams.

Please email me at mike.w.henderson.88@gmail.com if you have any questions or comments.
