--TEST--
Connect to MongoDB with using default auth mechanism #002
--SKIPIF--
<?php require "tests/utils/basic-skipif.inc"?>
--FILE--
<?php
require_once "tests/utils/basic.inc";

$username = "root";
$password = "tooring";
$database = "admin";

$parsed = parse_url(MONGODB_STANDALONE_AUTH_URI);
$dsn = sprintf("mongodb://%s:%s@%s:%d/%s", $username, $password, $parsed["host"], $parsed["port"], $database);
$manager = new MongoDB\Driver\Manager($dsn);

$bulk = new MongoDB\Driver\BulkWrite;

$bulk->insert(array("my" => "value"));
throws(function() use($manager, $bulk) {
    $retval = $manager->executeBulkWrite(NS, $bulk);
}, "MongoDB\Driver\AuthenticationException");

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
OK: Got MongoDB\Driver\AuthenticationException
===DONE===
