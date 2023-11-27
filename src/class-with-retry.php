<?php

namespace XWP\Wait_For;

class With_Retry {

	protected $event;

	public function __construct( $event ) {
		if ( is_callable( $event ) ) {
			$event = new Event( $event );
		}

		$this->event = $event;
	}

	public function run( $timeout, $sleep_throttle = 1 ) {
		$timer  = new Timer( $timeout );
		$result = $this->event->run();

		while ( ! $this->event->successful() && ! $timer->done() ) {
			$result = $this->event->run();
			sleep( max( 1, $sleep_throttle ) );
		}

		return $result;
	}
}
