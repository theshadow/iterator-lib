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
 