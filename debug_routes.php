<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

$routes = $app->make('router')->getRoutes()->getRoutes();
foreach ($routes as $route) {
    if (strpos($route->uri(), 'it-support') !== false) {
        echo "Found: " . $route->uri() . " => " . $route->getActionName() . "\n";
    }
}
