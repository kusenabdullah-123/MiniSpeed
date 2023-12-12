<?php
use App\Controllers\HomeController;

define('BASEPATH', __DIR__);
require 'vendor/autoload.php';
require './app/Config/database.php';

MiniSpeed\Router::get('/home/:id/:nama',[HomeController::class,'row']);
MiniSpeed\Router::get('/home/:id',[HomeController::class,'result']);

MiniSpeed\Framework::run();