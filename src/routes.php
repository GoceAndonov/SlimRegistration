<?php

$app->get('/', 'LoginController:index');

$app->post('/', 'LoginController:checkUser');

$app->get('/register', 'RegisterController:index');

$app->post('/register', 'RegisterController:register');

$app->get('/register/checkMail', 'RegisterController:checkMail');

$app->get('/register/verify', 'RegisterController:verify');

$app->post('/pixel', 'PixelController:storePixel');

$app->get('/pixel/list', 'PixelController:listPixel');
