<?php
namespace Manager;

use Framework\Routes;
use \Manager\Controllers\AuthManager;

class ManagerRoutes implements Routes {
    public function getRoutes() {

        $managerController = new AuthManager();

        $routes = [
            '' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'show'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'show'
                ]

            ],
            'misja' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'show'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'show'
                ]
            ]
        ];

        return $routes;
    }
}