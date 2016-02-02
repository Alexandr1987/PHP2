<?php

use App\Models\User;

require __DIR__ . '/autoload.php';

$user = new User();
$user->name = 'Alexandr';
$user->email = 'v@pupkin.ru';
$articles = $user::findAll();

foreach ($articles as $value){
    echo $value->name;
    echo $value->email.'<br>';
}



$user->update(2);




