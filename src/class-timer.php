<?php

namespace XWP\Wait_For;

class Timer {

	protected $time_started;

	protected $timeout;

	public function __construct( $timeout ) {
		$this->timeout      = intval( $timeout );
		$this->time_started = time();
	}

	public function done() {
		return ( time() > $this->time_started + $this->timeout );
	}

}
