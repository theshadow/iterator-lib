<?php
/**
 * Contains the StablePriorityQueue Class
 *
 * PHP version 5.3+
 *
 * @author     Xander Guzman <xander.guzman@shadowpedia.info>
 * @license    BSD
 * @link       http://www.github.com/theshadow/intervaliterator
 */

namespace IteratorLib\Collection;

/**
 * Iterator class based on the SplPriorityQueue that can handle objects with the same priority
 */
class StablePriorityQueue extends \SplPriorityQueue
{
	protected $serial = PHP_INT_MAX;

	/**
	 * @param mixed $value
	 * @param mixed $priority
	 */
	public function insert($value, $priority) {
		parent::insert($value, array($priority, $this->serial--));
	}
}
 