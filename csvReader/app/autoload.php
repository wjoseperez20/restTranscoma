<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** Agregando configuracion y setup para mongodb*/
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;



/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';


AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;




