<?php
/*
 * Original project of REST controller (c) Tom Butler https://r.je/
 */
try {
    require __DIR__ . '/../vendor/autoload.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $entryPoint = new \Framework\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Manager\ManagerRoutes());
    $entryPoint->run();
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    include __DIR__ . '/../templates/layout.html.php';
}