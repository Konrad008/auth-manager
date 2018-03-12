<?php

namespace Manager;

use \Manager\Controllers\AuthManager;

/**
 * Class ManagerRoutes
 * @package Manager
 */
class ManagerRoutes
{
    /**
     * @return array
     */
    public function getRoutes()
    {

        $managerController = new AuthManager();

        $routes = [
            '' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'mainPage',
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'mainPage',
                ]
            ],
            'useradd' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'userAdd',
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'userAdding',
                ]
            ],
            'groupadd' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'groupAdd',
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'groupAdding',
                ]
            ],
            'userdelete' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'userDelete',
                    'urlVars' => true,
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'userDelete',
                    'urlVars' => true,
                ]
            ],
            'groupdelete' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'groupDelete',
                    'urlVars' => true,
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'groupDelete',
                    'urlVars' => true,
                ]
            ],
            'useredit' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'userEdit',
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'userEditing',
                    'urlVars' => true,
                ]
            ],
            'groupedit' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'groupEdit'
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'groupEditing',
                    'urlVars' => true,
                ]
            ],
            'changepass' => [
                'POST' => [
                    'controller' => $managerController,
                    'action' => 'passwordChange',
                ],
                'GET' => [
                    'controller' => $managerController,
                    'action' => 'passwordChanging',
                    'urlVars' => true,
                ]
            ],
        ];

        return $routes;
    }
}