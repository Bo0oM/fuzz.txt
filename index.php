<?php
require __DIR__.'/vendor/autoload.php';

$obj = new \SystemFailure\SiteChecker("$argv[1]");
print_r($obj->run("fuzz.txt"));