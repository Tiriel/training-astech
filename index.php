<?php

use App\Foo\Bar;
use App\User\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__.'/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__.'/templates');
$twig = new Environment($loader);

$user = new User('Benjamin');
echo $twig->render('hello.html.twig', ['user' => $user]);

$bar = new Bar();
if ($bar instanceof Bar) {
    echo "Bar created".\PHP_EOL;
}
