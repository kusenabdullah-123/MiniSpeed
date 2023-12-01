<?php
use App\Controllers\HomeController;

define('BASEPATH', __DIR__);
require 'vendor/autoload.php';
require './app/Config/database.php';

MiniSpeed\Router::get('/home',[HomeController::class,'result']);
// MiniSpeed\Router::post('/home/:id',[HomeController::class,'row']);
MiniSpeed\Framework::run();