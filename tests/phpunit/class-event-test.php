<?php
/**
 * Class Event_Test.
 *
 * @package XWP\Wait_For
 */

use PHPUnit\Framework\TestCase;
use XWP\Wait_For\Event;

class Event_Test extends TestCase {

	/**
	 * Events can be defined and run.
	 *
	 * @return void
	 */
	public function test_can_run_event() {
		$event = new Event(
			function() {
				return 123;
			}
		);

		$this->assertFalse(
			$event->successful(),
			'Events not run should be reported as unsuccessful.'
		);

		$this->assertEquals( 123, $event->run() );
		$this->assertTrue( $event->successful() );
	}

	/**
	 * Ensure PHP Exceptions don't cause fatal errors.
	 */
	public function test_can_catch_exceptions() {
		$event = new Event(
			function() {
				throw new Exception( 'Custom exceptions.' );
			}
		);

		$result = $event->run();

		$this->assertEquals( 'Custom exceptions.', $result->getMessage() );
		$this->assertFalse( $event->successful() );
	}

}
