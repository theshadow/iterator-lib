<?php
/**
 * Contains the IntervalIterator
 *
 * PHP version 5.3+
 *
 * @author     Xander Guzman <xander.guzman@shadowpedia.info>
 * @license    BSD
 * @link       http://www.github.com/theshadow/iteratorlib
 */

namespace IteratorLib\Iterator;

use IteratorLib\Iterator\AppendStablePriorityQueueIterator;
use IteratorLib\Iterator\ReverseArrayIterator;

/**
 * An aggregate iterator that iterates over other iterators based on defined intervals.
 *
 * Rules:
 *     1) You can add multiple items at the same interval, higher priorities are used first. If all the priorities
 *        are the same they will be read in insertion order.
 *     2) If multiple intervals match the current offset (e.g. 3 and 5 would match at 15) the higher interval wins
 *        out until it is out of items at that interval.
 *     3) Intervals are 1 based and 0 is an invalid interval.
 *
 * Notes:
 *     If an offset comes up without a matching interval NULL is returned so long as the iterator is still considered
 *     valid. As such, you should fill out a default iterator at interval 1 with enough items to cover the items
 *     in the other iterators
 *
 */
class IntervalIterator implements \Iterator
{
	/**
	 * @var AppendStablePriorityQueueIterator[]
	 */
	protected $intervals;

	/**
	 * @var int
	 */
	protected $offset;

	/**
	 * An aggregate iterator that iterates over items in the contained iterators based on the defined intervals
	 *
	 * @param int $offset The initial starting offset
	 */
	public function __construct($offset = 1)
	{
		$this->intervals = array();
		$this->setOffset($offset);
	}

	/**
	 * Add an iterator at the specified interval
	 *
	 * @param \Iterator $iterator The iterator to add
	 * @param int      $interval The interval value to switch on.
	 * @param int      $priority In the event of a tie on an interval it will first pull from the one with the higher
	 *                           priority and default to first-in-first-out if the priorities are equal.
	 *
	 * @return $this
	 */
	public function interval(\Iterator $iterator, $interval = 1, $priority = 0)
	{
		if (!isset($this->intervals[$interval])) {
			$this->intervals[$interval] = new AppendStablePriorityQueueIterator();
		}

		$this->intervals[$interval]->append($iterator, $priority);

		return $this;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{

		// we loop from the reverse because higher intervals take precedence over lower ones, because they are
		// considered to be more rare and by that point, more important. For example, if two iterators are defined
		// 3 and 5, 5 is going to be used up before 3. Same with 1 and 2, where 2 would be used up first.
		$reverseIter   = new ReverseArrayIterator($this->intervals, true);
		$result        = null;

		/** @var AppendStablePriorityQueueIterator $queueIter */
		foreach ($reverseIter as $interval => $queueIter) {
			if ($this->offset % $interval) continue; // if the interval does not match skip it
			if (!$queueIter->valid()) continue; // if the iterator itself is not valid skip it

			// if we haven't skipped it then grab the next item
			$result = $queueIter->current();

			// move the queue up
			$queueIter->next();

			// break out.
			break;
		}

		return $result;

	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 *
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		$this->offset++;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 *
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return $this->offset;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 *
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 *       Returns true on success or false on failure.
	 */
	public function valid()
	{
		// if any of the interval iterators are valid the whole iterator is considered valid.
		/** @var AppendStablePriorityQueueIterator $interval */
		foreach ($this->intervals as $interval) {
			if ($interval->valid()) return true;
		}

		return false;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 *
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		/** @var AppendStablePriorityQueueIterator $queue */
		array_walk($this->intervals, function ($queue) {
			$queue->rewind();
		});

		$this->offset = 1;
	}

	/**
	 * Set the offset
	 *
	 * @param int $offset the offset value
	 *
	 * @return $this
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
		return $this;
	}

}
 