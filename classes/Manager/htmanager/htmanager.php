<?php

namespace Manager\htmanager;

use WhiteHat101\Crypt\APR1_MD5;

/**
 * Class htmanager
 * @package Manager\htmanager
 * @author Konrad Albrecht <kontakt@konradalbrecht.pl>
 */
class htmanager {

    /**
     * @var string
     */
    private $passwdFile;
    /**
     * @var string
     */
    private $groupsFile;

    /**
     * htmanager constructor.
     * @param string $passwdFile
     * @param string $groupsFile
     */
    public function __construct(string $passwdFile, string $groupsFile) {
        $this->passwdFile = $passwdFile;
        $this->groupsFile = $groupsFile;
    }

    /**
     * @return array
     */
    public function getUsers() : array {
        $return = [];
        foreach($this->readPasswd() as $key => $value) {
            $return[] = $key;
        }

        return $return;
    }

    /**
     * @param string $user
     * @param string $password
     * @return bool
     */
    public function saveUser(string $user, string $password) {
        $tmpArray = $this->readPasswd();
        $tmpArray[strtolower($user)] = APR1_MD5::hash($password);

        if ($this->writePasswd($tmpArray)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $user
     */
    public function deleteUser(string $user) {
        $tmpArray = $this->readPasswd();
        unset($tmpArray[$user]);

        $this->writePasswd($tmpArray);
        $this->deleteUserFromGroups($user);
    }

    /**
     * @param string $user
     */
    public function deleteUserFromGroups(string $user) {
        $tmpArray = $this->readGroups();
        $tmpArrayTwo = [];

        foreach ($tmpArray as $key => $group) {

            if (array_search($user, $group) !== false) {
                unset($group[array_search($user, $group)]);
            }

            $tmpArrayTwo[$key] = $group;
        }

        $this->writeGroups($tmpArrayTwo);
    }

    /**
     * @param string $user
     * @param array $groups
     */
    public function addUserToGroups(string $user, array $groups) {
        $tmpArray = $this->readGroups();

        foreach ($groups as $key => $value) {
            $tmpArray[$value][] = $user;
        }

        $this->writeGroups($tmpArray);
    }

    /**
     * @return array
     */
    public function getGroups() : array {
        $return =[];

        $tmpArray = $this->readGroups();
        foreach ($tmpArray as $key => $value) {
            $return[] = $key;
        }

        return $return;
    }

    /**
     * @param string $group
     * @param array $groupUsers
     */
    public function saveGroup(string $group, array $groupUsers = []) {
        $tmpArray = $this->readGroups();
        $tmpArray[strtolower($group)] = $groupUsers;

        $this->writeGroups($tmpArray);
    }

    /**
     * @param string $group
     */
    public function deleteGroup(string $group) {
        $tmpArray = $this->readGroups();
        unset($tmpArray[$group]);

        $this->writeGroups($tmpArray);
    }

    /**
     * @param string $groupName
     * @return array
     */
    public function getGroupUsers(string $groupName) : array {
        $tmpArray = $this->readGroups();

        return $tmpArray[strtolower($groupName)];
    }

    /**
     * @param string $userName
     * @return array
     */
    public function getUserGroups(string $userName) : array {
        $return = [];
        $tmpArray = $this->readGroups();

        foreach ($tmpArray as $key => $value) {
            if (array_search(strtolower($userName), $value) !== false) {
                $return[] = $key;
            }
        }

        return $return;
    }

    /**
     * @param string $userName
     * @return array
     */
    public function getActiveGroups(string $userName) : array {
        $tmpArray = $this->getGroups();
        $tmpArrayTwo = $this->getUserGroups($userName);
        $tmpArrayThree = array_diff($tmpArray, $tmpArrayTwo);

        return [
            $tmpArrayTwo,
            $tmpArrayThree,
        ];
    }

    /**
     * @param string $groupName
     * @return array
     */
    public function getActiveUsers(string $groupName) : array  {
        $tmpArray = $this->getUsers();
        $tmpArrayTwo = $this->getGroupUsers($groupName);
        $tmpArrayThree = array_diff($tmpArray, $tmpArrayTwo);

        return [
            $tmpArrayTwo,
            $tmpArrayThree,
        ];
    }

    /**
     * @param string $userName
     * @param array $groups
     * @param string|null $newUserName
     */
    public function editUser(string $userName, array $groups, string $newUserName = null) {
        if ($newUserName === null) {
            $newUserName = $userName;
        }
        $password = ($this->getUser($userName))[$userName];

        $this->deleteUserFromGroups($userName);
        $this->deleteUser($userName);

        $this->saveUserNohash($newUserName, $password);
        $this->addUserToGroups($newUserName, $groups);
    }

    /**
     * @param string $groupName
     * @param array $users
     * @param string|null $newGroupName
     */
    public function editGroup(string $groupName, array $users, string $newGroupName = null) {
        if ($newGroupName === null) {
            $newGroupName = $groupName;
        }

        $this->deleteGroup($groupName);
        $this->saveGroup($newGroupName, $users);
    }

    /**
     * @param string $user
     * @param string $password
     */
    private function saveUserNohash(string $user, string $password) {
        $tmpArray = $this->readPasswd();
        $tmpArray[strtolower($user)] = $password;

        $this->writePasswd($tmpArray);
    }

    /**
     * @param string $user
     * @return array
     */
    private function getUser(string $user) : array {
        $return = [];
        $tmpArray = $this->readPasswd();

        $tmpVar = array_search($user, array_flip($tmpArray));
        $return[$user] = $tmpVar;

        return $return;
    }

    /**
     * @param array $passwdArray
     * @return bool
     */
    private function writePasswd(array $passwdArray) {
        $fileContents = '';

        foreach($passwdArray as $key => $value) {
            $fileContents .= strtolower($key).':'.$value.PHP_EOL.'';
        }

        if (file_put_contents($this->passwdFile, $fileContents)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $groupArray
     * @return bool
     */
    private function writeGroups(array $groupArray) {
        $fileContents = '';

        foreach($groupArray as $key => $value) {
            $fileContents .= strtolower($key).': ';
            foreach ($value as $user) {
                $fileContents .= strtolower($user).' ';
            }
            $fileContents = trim($fileContents).PHP_EOL.'';
        }
        if (file_put_contents($this->groupsFile, $fileContents)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    private function readGroups() : array {
        $return = [];
        $file = file($this->groupsFile, FILE_IGNORE_NEW_LINES);

        foreach ($file as $line) {

            if (!empty($line)) {
                $tmpArray   = explode(':', $line);
                $groupname  = trim(array_shift($tmpArray));
                $groupusers = explode(' ', trim($tmpArray[0]));
            }
            foreach ($groupusers as $key => $user) {
                $groupusers[$key] = $user;
            }

            $return[strtolower($groupname)] = $groupusers;
        }

        return $return;
    }

    /**
     * @return array
     */
    private function readPasswd() : array {
        $return = [];
        $file = file($this->passwdFile, FILE_IGNORE_NEW_LINES);

        foreach ($file as $line) {
            if (!empty($line)) {
                $tmpArray  = explode(':', $line);
                $username  = trim($tmpArray[0]);
                $hash      = trim($tmpArray[1]);
            }
            $return[$username] = $hash;
        }

        return $return;
    }
}