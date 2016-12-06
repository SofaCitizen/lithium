<?php
/**
 * li₃: the most RAD framework for PHP (http://li3.me)
 *
 * Copyright 2016, Union of RAD. All rights reserved. This source
 * code is distributed under the terms of the BSD 3-Clause License.
 * The full license text can be found in the LICENSE.txt file.
 */

namespace lithium\data\source\mongo_db;

use MongoGridFSFile;
use IteratorIterator;

/**
 * This is the result class for all MongoDB. It needs a `MongoCursor` as
 * a resource to operate on.
 *
 * @link http://php.net/manual/en/class.mongocursor.php
 */
class Result extends \lithium\data\source\Result {

	protected $_it = null;

	/**
	 * Fetches the next result from the resource.
	 *
	 * @return array|boolean|null Returns a key/value pair for the next result,
	 *         `null` if there is none, `false` if something bad happened.
	 */
	protected function _fetch() {
		if (!$this->_resource) {
			return false;
		}
		if (!$this->_it) {
			$this->_resource->setTypeMap(['root' => 'array', 'document' => 'array']);
			$this->_it = new IteratorIterator($this->_resource);
			$this->_it->rewind();
		}
		if (!$this->_it->valid()) {
			return;
		}
		$result = $this->_it->current();
		$this->_it->next();

		return [$this->_iterator, $result];
	}
}

?>