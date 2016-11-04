<?php

use Controllers\InstagramController;


/**
 * handle static requests
 */
if (array_key_exists('REQUEST_URI', $_SERVER) &&
    preg_match('/\.(?:html|js|css|png|jpg|jpeg|gif|woff|ttf)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

require_once __DIR__.'/../vendor/autoload.php';

/**
 * create and config Silex App
 */
$app = new Silex\Application();
$app->register(new Silex\Provider\SessionServiceProvider());
if (!isset($env)) {
    $env = 'dev';
}

$app['mustache'] = new Mustache_Engine(
    [
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__.'/../app/Views', ['extension' => '.html']),
    ]
);

$app->get('/', "Controllers\InstagramController::showInstagram");


$app->run();
