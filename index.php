<?php

$f3=require('lib/base.php');

$f3->config('config/config.ini');
$f3->config('config/routes.ini');

$f3->LANGUAGE = $f3->get('sitelang');

$f3->set('ONERROR',function($f3){
  echo \Template::instance()->render('error.html');
  $e = $f3->get('EXCEPTION');
  // There isn't an exception when calling `Base->error()`.
  if (!$e instanceof Throwable) {
	$logger = new Log('logs/'.date("Ymd").'error.log');
	$logger->write( $f3->get('ERROR.code') . ": ". $f3->get('ERROR.text'). " trace: ". $f3->get('ERROR.trace'),'r'  );
  }
});

$f3->logger = new Log('logs/'.date("Ymd").'.log');
$f3->session = new Session();
$f3->run();
