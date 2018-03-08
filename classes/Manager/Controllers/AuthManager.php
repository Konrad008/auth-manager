<?php
namespace Manager\Controllers;

use Manager\htmanager\htmanager;

/**
 * Class AuthManager
 * @package Manager\Controllers
 * @author Konrad Albrecht <kontakt@konradalbrecht.pl>
 */
class AuthManager
{
    /**
     * @var htmanager
     */
    private $htservice;

    /**
     * AuthManager constructor.
     */
    public function __construct()
    {
        $fileName = __DIR__.'/../../../config.yml';
        $yamlFile = fopen($fileName, 'r') or die("Unable to open file!");
        $yaml = yaml_parse(fread($yamlFile,filesize($fileName)));

        $this->htservice = new htmanager($yaml['htpasswd'], $yaml['htgroups']);
    }

    /**
     * @return array
     */
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
                'grupy' => $groupsWithUsers,
            ],
            ];
    }

    /**
     * @param $user
     */
    public function userDelete($user)
    {
        $this->htservice->deleteUser($user[0]);

        header('location: /');
    }

    /**
     * @param $group
     */
    public function groupDelete($group)
    {
        $this->htservice->deleteGroup($group[0]);

        header('location: /');
    }

    /**
     *
     */
    public function userAdd()
    {
        $this->htservice->saveUser($_POST['user'], $_POST['password']);

        header('location: /');
    }

    /**
     * @return array
     */
    public function userAdding()
    {
        return [
            'template' => 'addUser.html.php',
            'title' => 'AM Add user'
        ];
    }

    /**
     *
     */
    public function groupAdd()
    {
        $this->htservice->saveGroup($_POST['group']);

        header('location: /');
    }

    /**
     * @return array
     */
    public function groupAdding()
    {
        return [
            'template' => 'addGroup.html.php',
            'title' => 'AM Add group'
        ];
    }

    /**
     *
     */
    public function userEdit()
    {
        $this->htservice->editUser($_POST['user'], $_POST['groups'], $_POST['newuser']);

        header('location: /');
    }

    /**
     * @param $user
     * @return array
     */
    public function userEditing($user)
    {
        $tmpArray = $this->htservice->getActiveGroups($user[0]);

        return [
            'template' => 'editUser.html.php',
            'title' => 'AM Edit user',
            'variables' => [
                'user' => $user[0],
                'activegroups' => $tmpArray[0],
                'inactivegroups' => $tmpArray[1],
                ],
        ];
    }

    /**
     * @param $user
     * @return array
     */
    public function passwordChanging($user)
    {

        return [
            'template' => 'changePassword.html.php',
            'title' => 'AM Change password',
            'variables' => [
                'user' => $user[0],
                ],
        ];
    }

    /**
     *
     */
    public function passwordChange()
    {
        $this->htservice->saveUser($_POST['user'], $_POST['password']);

        header('location: /');
    }

    /**
     *
     */
    public function groupEdit()
    {
        $this->htservice->editGroup($_POST['group'], $_POST['users'], $_POST['newgroup']);

        header('location: /');
    }

    /**
     * @param $group
     * @return array
     */
    public function groupEditing($group)
    {
        $tmpArray = $this->htservice->getActiveUsers($group[0]);

        return [
            'template' => 'editGroup.html.php',
            'title' => 'AM Edit group',
            'variables' => [
                'group' => $group[0],
                'activeusers' => $tmpArray[0],
                'inactiveusers' => $tmpArray[1],
            ],
        ];
    }
}