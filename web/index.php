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


$app->get('/status', function() use($app) {

header (' ', true, 201);

}



$app->post('/validarFirma', function() use($app) {
  $string= $_REQUEST['mensaje'];
  $hashGuardado= hash( 'sha256', $string );

  $valido= false;
  $hashDado = $_REQUEST['hash'];

  if ($hashGuardado==$hashDado)	{
  		$valido = True;
		
		$miArray = array ("valido"=>$valido, "mensaje"=> $string);
		return (json_encode($miArray));
        
  		
  		//return "valido: " . True . "\r\n " . "mensaje: " . $string;   

  }
  else {

  	return "valido: " ;
  	
  }




});

$app->run();
