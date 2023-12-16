<?php
use App\Controllers\HomeController;

define('BASEPATH', __DIR__);
require 'vendor/autoload.php';
require './app/Config/database.php';

MiniSpeed\Router::get('/mini',[HomeController::class,'result']);
MiniSpeed\Router::post('/mini',[HomeController::class,'insert']);
MiniSpeed\Router::patch('/mini/:id',[HomeController::class,'update']);
MiniSpeed\Router::delete('/mini/:id',[HomeController::class,'delete']);

MiniSpeed\Framework::run();