<?php

class User
{

    private $conn;
    private $table_name = 'users';
    private $table_name_credentials = 'login_credentials';

    public $user_id;
    public $user_first_name;
    public $user_last_name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUserById($id)
    {
        $query = "
            SELECT
                u.user_first_name, u.user_last_name
            FROM
                users u
            WHERE
                u.user_id = " . $id . ";
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function addUser($first_name, $last_name)
    {
        $query = "
            INSERT INTO 
                " . $this->table_name . "
            VALUES
                ('', '" . $first_name . "', '" . $last_name . "');
        ";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return array(
                'check' => 'success'
            );
        } else {
            return array(
                'check' => 'failure'
            );
        }
    }

    public function addUserCredentials($id, $login, $password)
    {
        $query = "
            INSERT INTO
                " . $this->table_name_credentials . "
            VALUES
                ('', " . $id . ", '" . $login . "', '" . hash('sha256', $password) . "');
        ";

        echo $query;

        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return array(
                'check' => 'success'
            );
        } else {
            return array(
                'check' => 'failure'
            );
        }
    }

    public function loginUser($login, $password)
    {
        $query = "
            SELECT 
                u.user_id, u.user_first_name, u.user_last_name, au.author_id
            FROM
                " . $this->table_name . " u
            LEFT JOIN
                " . $this->table_name_credentials . " cred
            ON
                u.user_id = cred.user_id
            LEFT JOIN 
                authors au
            ON
                u.user_id = au.user_id
            WHERE
                cred.login_user_name = '" . $login . "'
            AND 
                cred.login_password = '" . hash('sha256', $password) . "'
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function makeAnAuthor($id)
    {
        $query = "
            INSERT INTO
                authors
            VALUES
                (null, " . $id . ");
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getLastUserId()
    {
        $query = "
            SELECT
                user_id
            FROM
                users
            ORDER BY user_id DESC LIMIT 1;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function deleteUser($user_id)
    {
        $query = "
            DELETE FROM
                " . $this->table_name . "
            WHERE 
                user_id = " . $user_id . "
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}