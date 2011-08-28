<?php

require_once('vendor/Symfony/ClassLoader/UniversalClassLoader.php');
$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespace('Avanwieringen', __DIR__ . '/src');
$classLoader->register();