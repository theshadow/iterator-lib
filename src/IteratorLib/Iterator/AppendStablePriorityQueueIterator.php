<?php
/**
 * Contains the AppendStablePriorityQueueIterator Class
 *
 * PHP version 5.3+
 *
 * @author     Xander Guzman <xander.guzman@shadowpedia.info>
 * @license    BSD
 * @link       http://www.github.com/theshadow/intervaliterator
 */

namespace IteratorLib\Iterator;

use IteratorLib\Collection\StablePriorityQueue;

/**
 * Iterator class that combines the benefits of the AppendIterator and the StablePriorityQueue iterator.
 */
class AppendStablePriorityQueueIterator implements \Iterator
{
	/**
	 * @var StablePriorityQueue
	 */
	protected $iterators;

	/**
	 * An iterator that combines the benefits of the AppendIterator and the StablePriorityQueue
	 */
	public function __construct()
	{
		$this->iterators = new StablePriorityQueue();
	}

	/**
	 * Append an iterator.
	 *
	 * @param \Iterator $iterator Iterator to append
	 * @param int      $priority Priority at which
	 */
	public function append(\Iterator $iterator, $priority = 0)
	{
		$this->iterators->insert($iterator, $priority);
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
		return $this->iterators->current()->current();
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
		if (!$this->iterators->current()->valid()) {
			$this->iterators->next();
			return;
		}
		$this->iterators->current()->next();
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
		return $this->iterators->key();
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
		if (!$this->iterators->valid()) return false;
		if (!$this->iterators->current()->valid()) $this->next();
		return $this->iterators->valid();
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
		$this->iterators->rewind();
	}
}
 