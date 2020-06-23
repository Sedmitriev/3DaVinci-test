<?php

namespace Sedmit\DaVinci\Models;

use Sedmit\DaVinci\Core\DBConnection;
// use Sedmit\DaVinci\Api;

class UserModel {
    private $db;

    public function __construct($config)
    {
        $this->db = DBConnection::getInstance();
        $this->db->initConnection($config['db']);
    }

    public function addUsers(array $users) {
        for ($i = 0; $i < count($users); $i++) {
            $isUserIdExist = $this->isUserIdExist($users[$i]['id']);
            $userParams = [
                "id" => $users[$i]['id'],
                "login" => $users[$i]['login']
            ];
            if (!$isUserIdExist) {
                $insertUserSql = "INSERT INTO user (github_id, github_login) VALUES (:id, :login)";
                $this->db->executeSql($insertUserSql, $userParams);
            } else {
                $updateUserSql = "UPDATE user SET github_login = :login WHERE github_id = :id;";
                $this->db->executeSql($updateUserSql, $userParams);
            }

        }
    }

    private function isUserIdExist($id) {
        $sql = "SELECT * FROM user WHERE github_id = :id";
        $user = $this->db->execute($sql, ["id" => $id], false);
        if (count($user) > 0) return true;
        return false;
    }
}