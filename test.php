<?php

require_once 'classes/SimpleCacheTest.class.php';

$t = new SimpleCacheTest('test', 5);
echo $t->get();

