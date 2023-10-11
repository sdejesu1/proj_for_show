<?php
define('DEBUG', false);
$SERVER = filter_input_array
(INPUT_SERVER, FILTER_SANITIZE_STRING);

// defining database name constant
define('DATABASE_NAME', 'SDEJESU1_cs148_Final');

// defining server as a constant
define('SERVER', $SERVER['SERVER_NAME']);

// defining domain
define('DOMAIN', '//' . SERVER);

// defining php self server
define('PHP_SELF', $SERVER['PHP_SELF']);

// defining path parts
define('PATH_PARTS', pathinfo(PHP_SELF));

// defining base path
define('BASE_PATH', DOMAIN . PATH_PARTS['dirname'] . '/');

// defining lib path
define('LIB_PATH', 'lib/');

// if debug statement
if (DEBUG) {
    print '<p>Domain: ' . DOMAIN;
    print '<p>PHP SELF: ' . PHP_SELF;
    print '<p>PATH PARTS<pre>';
    print_r(PATH_PARTS);
    print'</pre></p>';
    print '<p>BASE_PATH: ' . BASE_PATH;
    print '<p>LIB_PATH: ' . LIB_PATH;
}

?>