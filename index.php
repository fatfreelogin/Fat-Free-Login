<?php

require 'vendor/autoload.php';
$f3 = \Base::instance();

$f3->config('config/config.ini');
$f3->config('config/routes.ini');

$f3->LANGUAGE = $f3->get('sitelang');

$f3->set('BASE', 'https://BTAXFF3PetiteVue.spurblickale.repl.co');

$f3->set('ONERROR',function($f3){
  echo \Template::instance()->render('error.html');
  $e = $f3->get('EXCEPTION');
  // There isn't an exception when calling `Base->error()`.
  if (!$e instanceof Throwable) {
	$logger = new Log('logs/'.date("Ymd").'error.log');
	$logger->write( $f3->get('ERROR.code') . ": ". $f3->get('ERROR.text'). " trace: ". $f3->get('ERROR.trace'),'r'  );
  }
});

function isBetween($f, $t, $i) {
    return ($f > $t) ? !($t <= $i && $i <= $f) : ($f <= $i && $i <= $t);
}

$f3->set(
  "daytime",
  isBetween(
    "08:00:00",
    "18:00:00",
    "09:00:00"
  )
);
//$f3->set('SESSION.test',123);
//echo $f3->get('SESSION.test');



$f3->logger = new Log('logs/'.date("Ymd").'.log');
$f3->logger->erase();
// $f3->session = new Session();
$f3->run();
