# "Wait For" Helper for PHP

Wait for TCP connections to services with a timeout. Useful when waiting for services on Docker containers that take a while to start such as MySQL.

## Usage

Require this library as a development dependency for your project:

	composer require --dev xwp/wait-for

Use it in your project to wait for a TCP response from `localhost:3306`:

```php
// Include the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

$connection = new XWP\Wait_For\Tcp_Connection( 'localhost', 3306 );

try {
	$connection->connect( 30 );
} catch ( Exception $e ) {
	trigger_error( $e->getMessage(), E_USER_ERROR );
}
```

where `locahost` is the hostname, `3306` is the port number and `30` is the timeout in seconds.

## Design Decisions

- Use PHP exceptions on connection errors to ensure that applications relying on process return codes are made aware of the connection error.

## Examples

Use the included helpers to create your own waiting logic:

```php
use XWP\Wait_For\With_Retry;

$runner = new With_Retry(
	function() {
		// Do something here.
		return false;
	}
);

if ( ! $runner->run( 10 ) ) {
	trigger_error( 'Failed to connect!' );
}
```
