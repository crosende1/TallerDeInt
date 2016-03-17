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
 
$response = new \Phalcon\Http\Response();
//$response->setStatusCode(201);
$response->setJsonContent(setStatusCode(201));
$response->send();

});




$app->post('/validarFirma', function() use($app) {
  $string= $_REQUEST['mensaje'];
  $hashGuardado= hash( 'sha256', $string );
  $hashGuardado2=strtolower($hashGuardado);
  $hashDado = $_REQUEST['hash'];
  $hashDado2=strtolower($hashDado);

  $valido= false;
 


  if ($string == NULL || $hashDado== NULL){


  }


  if ($hashGuardado2 == $hashDado2)	{
  		$valido=true;
  		//$d = array();
  		$d=array('valido'=> $valido, 'mensaje'=>$string);
  		$json=json_encode($d);
  		return $json;
  		

  }
  else {

  		$d=array('valido'=> $valido, 'mensaje'=>$string);
  		$json=json_encode($d);
  		return $json;
  	
  }




});

$app->run();
