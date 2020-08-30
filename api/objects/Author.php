<?php

class Author
{

    private $conn;
    private $table_name = 'authors';
    private $table_name_au_art = 'authors_articles';
    private $table_name_articles = 'articles';

    public $author_id;
    public $record_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllArticlesByAuthorName($author_first_name, $author_last_name)
    {
        $query = "
            SELECT
                art.article_id, art.article_title, art.article_text, art.article_creation_date, u.user_first_name, u.user_last_name
            FROM
                articles art
            LEFT JOIN   
                authors_articles au_art
            ON 
                art.article_id = au_art.article_id
            LEFT JOIN
                authors au
            ON 
                au_art.author_id = au.author_id
            LEFT JOIN
                users u 
            ON 
                au.user_id = u.user_id
            WHERE
                u.user_first_name = '" . $author_first_name . "'
            AND
                u.user_last_name = '" . $author_last_name . "';
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getAllArticlesByAuthorId($id)
    {
        $query = "
            SELECT
                art.article_id, art.article_title, art.article_text, art.article_creation_date, u.user_first_name, u.user_last_name
            FROM
                articles art
            LEFT JOIN   
                authors_articles au_art
            ON 
                art.article_id = au_art.article_id
            LEFT JOIN
                authors au
            ON 
                au_art.author_id = au.author_id
            LEFT JOIN
                users u 
            ON 
                au.user_id = u.user_id
            WHERE
                au_art.author_id = " . $id . "
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function addArticle($article_title, $article_text)
    {
        $query = '
            INSERT INTO
                ' . $this->table_name_articles . '
            VALUES
                ("", "' . $article_title . '", "' . $article_text . '", (SELECT CURDATE()));   
        ';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addAuthorToArticle($author_id, $article_id)
    {
        $query = "
            INSERT INTO
                " . $this->table_name_au_art . "
            VALUES
                (" . $article_id . ", " . $author_id . ");
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getAuthorsByArticleId($id)
    {
        $query = "
            SELECT
                u.user_first_name, u.user_last_name
            FROM
                users u 
            LEFT JOIN
                authors au
            ON 
                u.user_id = au.user_id
            LEFT JOIN 
                authors_articles au_art
            ON
                au.author_id = au_art.author_id
            WHERE
                au_art.article_id = " . $id . "
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function deleteOldArticleAuthors($id)
    {
        $query = "
            DELETE FROM
                " . $this->table_name_au_art . "
            WHERE
                article_id = " . $id . ";
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

    public function addNewAuthorToArticle($article_id, $author_id)
    {
        $query = "
            INSERT INTO
                " . $this->table_name_au_art . "
            VALUES
                (" . $article_id . ", " . $author_id . ")
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

    public function getAuthorIdByName($author_first_name, $author_last_name)
    {
        $query = "
            SELECT
                au.author_id
            FROM
                " . $this->table_name . " au
            LEFT JOIN
                users u
            ON
                au.user_id = u.user_id
            WHERE
                u.user_first_name = '" . $author_first_name . "'
            AND
                u.user_last_name = '" . $author_last_name . "'
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['author_id'];
    }
}