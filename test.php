<?php

require_once __DIR__ .  '/classes/SimpleCacheTest.class.php';

$t = new SimpleCacheTest('test', 5);
echo $t->get();

