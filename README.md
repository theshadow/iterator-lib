iterator-lib
============

Contains some iterators and collections to add to the default SPL ones.


{% codeblock lang:php Example of the IntervalIterator %}
<?php

/**
 * TODO FINISH UNIT TESTS
 */

use IteratorLib\Iterator\IntervalIterator;

$intervalIterator = new IntervalIterator();

$regular = array('apple', 'air', 'amazon', 'amigo', 'across', 'amoeba', 'aardvark', 'ablating', 'aborning', 'aardwolf',
         'aberrant', 'ablators', 'abidance', 'abnormal', 'achieved', 'accuracy', 'alamo');
$special = array('zebra', 'zoo', 'zoology', 'zule', 'zimack', 'zap');
$sponsored = array('bog', 'bike', 'bat', 'bingo');
$ads = array('cat', 'cow', 'crow');

$regularIter = new ArrayIterator($regular);
$specialIter = new ArrayIterator($special);
$sponsoredIter = new ArrayIterator($sponsored);
$adsIter = new ArrayIterator($ads);

$intervalIterator->interval($regularIter);
$intervalIterator->interval($specialIter, 1, 10); // same interval, higher priority
$intervalIterator->interval($sponsoredIter, 5);
$intervalIterator->interval($adsIter, 8);


foreach ($intervalIterator as $key => $value) {
  echo $key, ': ';
  var_dump($value);
}
{% endcodeblock %}

{% codeblock lang:text Example output %}
$ php main.php
1: string(5) "zebra"
2: string(3) "zoo"
3: string(7) "zoology"
4: string(4) "zule"
5: string(3) "bog"
6: string(6) "zimack"
7: string(3) "zap"
8: string(3) "cat"
9: string(5) "apple"
10: string(4) "bike"
11: string(3) "air"
12: string(6) "amazon"
13: string(5) "amigo"
14: string(6) "across"
15: string(3) "bat"
16: string(3) "cow"
17: string(6) "amoeba"
18: string(8) "aardvark"
19: string(8) "ablating"
20: string(5) "bingo"
21: string(8) "aborning"
22: string(8) "aardwolf"
23: string(8) "aberrant"
24: string(4) "crow"
25: string(8) "ablators"
26: string(8) "abidance"
27: string(8) "abnormal"
28: string(8) "achieved"
29: string(8) "accuracy"
30: string(5) "alamo"
{% endcodeblock %}
