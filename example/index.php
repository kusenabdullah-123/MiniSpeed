<?php
use App\Controllers\HomeController;

define('BASEPATH', __DIR__);
require 'vendor/autoload.php';
require './app/Config/database.php';

MiniSpeed\Router::get('/home/:any',[HomeController::class,'result']);
MiniSpeed\Framework::run();