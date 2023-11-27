<?php

namespace XWP\Wait_For;

use Exception;

class Event {

	protected $callback;
	protected $success = false;

	public function __construct( $callback ) {
		$this->callback = $callback;
	}

	public function successful() {
		return $this->success;
	}

	public function run() {
		// Allow repeated calls if the callback throws an exception.
		try {
			$result = call_user_func( $this->callback );
		} catch ( Exception $e ) {
			return $e;
		}

		if ( $result ) {
			$this->success = true;
		}

		return $result;
	}
}
