<?php
/**
 * TCP Connection.
 *
 * @phpcs:disable WordPress.Security.EscapeOutput.ExceptionNotEscaped -- should be handled at the implementation level.
 */
namespace XWP\Wait_For;

use Exception;
use Throwable;

class Tcp_Connection {

	protected $hostname;

	protected $port;

	protected $timeout;

	public function __construct( $hostname, $port, $timeout = 10 ) {
		$this->hostname = $hostname;
		$this->port     = intval( $port );
		$this->timeout  = intval( $timeout );
	}

	public function connect( $timeout = null ) {
		$runner = new With_Retry( array( $this, 'open_socket' ) );

		if ( ! isset( $timeout ) ) {
			$timeout = $this->timeout;
		}

		$result = $runner->run( $timeout );

		if ( $result instanceof Throwable ) {
			throw $result;
		}

		return $result;
	}

	public function open_socket() {
		$socket = @fsockopen(
			$this->hostname,
			$this->port,
			$error_no,
			$error_str,
			1
		);

		if ( ! $socket ) {
			throw new Exception(
				sprintf(
					'Error: %s while opening a TCP connection to %s:%d',
					$error_str,
					$this->hostname,
					$this->port
				),
				$error_no
			);
		}

		fclose( $socket );

		return true;
	}
}
