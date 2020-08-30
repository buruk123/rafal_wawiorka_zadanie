<?php

class Article
{

    private $conn;
    private $table_name = 'articles';

    public $record_id;
    public $article_id;
    public $article_title;
    public $article_text;
    public $article_creaction_date;
    public $author_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllArticles()
    {
        $query = "
            SELECT
                art.article_id, art.article_title, art.article_text, art.article_creation_date
            FROM
                articles art
            ORDER BY art.article_id DESC;
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
            WHERE au_art.article_id = " . $id . "
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getArticleById($id)
    {
        $query = "
            SELECT
                art.article_id, art.article_title, art.article_text, art.article_creation_date, u.user_first_name, u.user_last_name
            FROM
                " . $this->table_name . " art 
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
            WHERE art.article_id = " . $id . "
            LIMIT 1;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getTopThreeAuthorsWithMostArticlesLastWeek()
    {
        $query = "
            SELECT DISTINCT 
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
            LEFT JOIN
                articles art 
            ON
                au_art.article_id = art.article_id
            WHERE
                art.article_creation_date BETWEEN date_sub(now(), INTERVAL 1 WEEK) and now();
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getLastArticleId()
    {
        $query = "
            SELECT
                article_id
            FROM
                " . $this->table_name . "
            ORDER BY article_id DESC LIMIT 1;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }

    public function replaceDoubleQuoteToSingle($text)
    {
        return str_replace('"', "'", $text);
    }

    public function updateArticle($id, $title, $text, $creation_date)
    {
        $text = $this->replaceDoubleQuoteToSingle($text);

        $query = '
            UPDATE
                ' . $this->table_name . '
            SET
                article_title = "' . $title . '",
                article_text = "' . $text . '",
                article_creation_date = "' . date($creation_date) . '"
            WHERE 
                article_id = ' . $id . '
        ';

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

}