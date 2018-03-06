<?php
namespace Manager;

use \Manager\Controllers\AuthManager;

class ManagerRoutes {
    public function getRoutes() {

        $managerController = new AuthManager();

        $routes = [
            '' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'mainPage'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'mainPage'
                ]
            ],
            'useradd' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'userAdd'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'userAdding'
                ]
            ],
            'useredit' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'userEdit',
                    'urlVars' => true
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'editingUser',
                    'urlVars' => true
                ]
            ],
            'userdelete' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'mainPage'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'userDelete',
                    'urlVars' => true
                ]
            ],
            'groupadd' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'groupAdd'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'groupAdding'
                ]
            ],
            'groupedit' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'editGroup',
                    'urlVars' => true
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'editingGroup'
                ]
            ],
            'groupdelete' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'deleteUser',
                    'urlVars' => true
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'mainPage'
                ]
            ]
        ];

        return $routes;
    }
}