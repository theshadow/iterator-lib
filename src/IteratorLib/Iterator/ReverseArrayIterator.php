<?php
/**
 * Contains the ReverseArrayIterator Class
 *
 * PHP version 5.3+
 *
 * @author     Xander Guzman <xander.guzman@shadowpedia.info>
 * @license    BSD
 * @link       http://www.github.com/theshadow/intervaliterator
 */

namespace IteratorLib\Iterator;

/**
 * Reverse iterates over an array.
 */
class ReverseArrayIterator extends ArrayIterator
{

	/**
	 * An iterator that iterates over an array in reverse
	 *
	 * @param array $array        The array to iterate over
	 * @param null  $preserveKeys If TRUE will preserve the numeric keys
	 */
	public function __construct(array $array, $preserveKeys = null)
	{
		parent::__construct(array_reverse($array, $preserveKeys));
	}
}
 