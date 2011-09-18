<?php

require_once('vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php');
$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespace('Avanwieringen', __DIR__ . '/src');
$classLoader->registerNamespace('Symfony', __DIR__ . '/vendor');
$classLoader->register();