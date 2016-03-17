<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->post('/validarFirma', function() use($app) {
  $string= $_GET['mensaje'];
  $hashGuardado= hash( 'sha256', $string );

  $iguales= false;
  $HashDado = $_GET['hash'];

  if ($hashGuardado==$HashDado)	{
  		$iguales = true;
  		return "valido: " . $iguales . "\r\n " . "mensaje: " . $HashDado;   

  }
  else {

  	return "valido: " . $iguales . "\r\n " . "mensaje: " . $HashDado; 
  }


});

$app->run();
