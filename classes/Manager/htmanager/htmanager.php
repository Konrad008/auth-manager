<?php

namespace Manager\htmanager;

use WhiteHat101\Crypt\APR1_MD5;

class htmanager {

    private $passwdFile;
    private $groupsFile;

    public function __construct(string $passwdFile, string $groupsFile) {
        $this->passwdFile = $passwdFile;
        $this->groupsFile = $groupsFile;
    }

    public function getUsers() : array {
        $return = [];
        foreach($this->readPasswd() as $key => $value) {
            $return[] = $key;
        }

        return $return;
    }

    public function saveUser(string $user, string $password) {
        $tmpArray = $this->readPasswd();
        $tmpArray[strtolower($user)] = APR1_MD5::hash($password);

        if ($this->writePasswd($tmpArray)){
            return true;
        } else {
            return false;
        }
    }

    public function getGroups() : array {
        $return =[];

        $tmpArray = $this->readGroups();
        foreach ($tmpArray as $key => $value) {
            $return[] = $key;
        }

        return $return;
    }

    public function saveGroup(string $group, array $groupUsers) {
        $tmpArray = $this->readGroups();
        $tmpArray[strtolower($group)] = $groupUsers;

        $this->writeGroups($tmpArray);
    }

    public function getGroupUsers(string $groupName) : array {
        $tmpArray = $this->readGroups();

        return $tmpArray[strtolower($groupName)];
    }

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