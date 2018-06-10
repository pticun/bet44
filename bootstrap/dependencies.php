<?php
// di
$injector = new \Auryn\Injector;
$signer = new Kunststube\CSRFP\SignatureGenerator(getenv('CSRF_SECRET'));
$injector->share($signer);
$blade = new duncan3dc\Laravel\BladeInstance(APP_PATH.'/views', APP_PATH.'/cache');
$injector->share($blade);
$injector->share('Acme\Http\Request');
$injector->share('Acme\Http\Response');
$injector->share(Goutte\Client::class);
//$injector->share(\GuzzleHttp\Client::class);
//$injector->share(Symfony\Component\DomCrawler\Crawler::class);
$injector->share('Acme\Http\Session');
//$injector->define('Acme\Auth\LoggedIn', ['session' => 'Acme\Http\Session']);
//$injector->make('Acme\Auth\LoggedIn');
return $injector;