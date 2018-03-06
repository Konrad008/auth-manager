<?php
namespace Manager\Controllers;

use Manager\htmanager\htmanager;

class AuthManager
{
    private $htservice;

    public function __construct()
    {
        $fileName = __DIR__.'/../../../config.yml';
        $yamlFile = fopen($fileName, 'r') or die("Unable to open file!");
        $yaml = yaml_parse(fread($yamlFile,filesize($fileName)));

        $this->htservice = new htmanager($yaml['htpasswd'], $yaml['htgroups']);
    }

    public function mainPage()
    {
        $usersWithGroups = [];
        $groupsWithUsers = [];

        $groups = $this->htservice->getGroups();
        $users  = $this->htservice->getUsers();

        foreach ($users as  $user) {
            $usersWithGroups[$user] = $this->htservice->getUserGroups($user);
        }
        foreach ($groups as $group) {
            $groupsWithUsers[$group] = $this->htservice->getGroupUsers($group);
        }

        return [
            'template' => 'main.html.php',
            'title' => 'AM Dashboard',
            'variables' => [
                'users' => $usersWithGroups,
                'groups' => $groupsWithUsers,
            ],
            ];
    }

    public function userDelete($user)
    {


        header('location: /');
    }

    public function userAdd()
    {
        $this->htservice->addUser($_POST['user'], $_POST['password']);

        header('location: /');
    }

    public function userAdding()
    {
        return [
            'template' => 'addUser.html.php',
            'title' => 'AM AddUser'
        ];
    }

    public function groupAdd()
    {

    }

    public function groupAdding()
    {
        return [
            'template' => 'addGroup.html.php',
            'title' => 'AM AddGroup'
        ];
    }
}