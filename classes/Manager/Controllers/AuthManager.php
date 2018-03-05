<?php
namespace Manager\Controllers;

use Apache2BasicAuth\Service as HTService;

class AuthManager
{
    private $htservice;

    public function __construct()
    {
        $fileName = __DIR__.'/../../../config.yml';
        $yamlFile = fopen($fileName, 'r') or die("Unable to open file!");
        $yaml = yaml_parse(fread($yamlFile,filesize($fileName)));

        $this->htservice = new HTService($yaml['htpasswd'], $yaml['htgroups']);
    }

    public function mainPage()
    {
        $usernames = $this->htservice->getUsernames();
        $users = $this->htservice->getUsers();
        $groupsnames = $this->htservice->getGroupNames();
        $groups = $this->htservice->getGroups();

        return [
            'template' => 'main.html.php',
            'title' => 'AM Dashboard',
            'variables' => [
                'usernames' => $usernames,
                'users' => $users,
                'groupsnames' => $groupsnames,
                'groups' => $groups,
            ],
            ];
    }

    public function userDelete($user)
    {
        $user = $this->htservice->findUser($user[0]);
        $this->htservice->removeUser($user);
        $this->htservice->write();

        header('location: /');
    }
    public function userAdd()
    {
        print_r($_POST);
        $user = $this->htservice->createUser();

        $user->setUsername($_POST['user'])
            ->setPassword($_POST['password']);

        $this->htservice->persist($user);

        $this->htservice->write();

        setcookie('notice', $_POST['user']);

        header('location: /');
    }
    public function userAdding()
    {
        return [
            'template' => 'addUser.html.php',
            'title' => 'AM AddUser'
        ];
    }
}