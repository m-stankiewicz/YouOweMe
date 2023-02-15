<?php

include "Post.php";

class PostDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare('SELECT posts.description, posts.title, posts.creation_time, posts.id, posts.user_id, users.username FROM posts JOIN users on users.id = user_id WHERE posts.id = ?;');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        return new Post($row['description'], $row['title'], $row['creation_time'], $row['id'], $row['user_id'], $row['username']);
    }

    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT posts.description, posts.title, posts.creation_time, posts.id, posts.user_id, users.username FROM posts JOIN users on users.id = user_id;');
        $stmt->execute();
        while($row = $stmt->fetch())
        {
            $post = new Post($row['description'], $row['title'], $row['creation_time'], $row['id'], $row['user_id'], $row['username']);
            $posts[] = $post;
        }
        return $posts;    
    }

    public function findAllByUserId($id) {
        $stmt = $this->pdo->prepare('SELECT posts.description, posts.title, posts.creation_time, posts.id, posts.user_id, users.username FROM posts JOIN users on users.id = user_id WHERE user_id = ?;');
        $stmt->execute([$id]);
        $posts = [];
        while($row = $stmt->fetch())
        {
            $post = new Post($row['description'], $row['title'], $row['creation_time'], $row['id'], $row['user_id'], $row['username']);
            $posts[] = $post;
        }
        return $posts;
    }

    public function createPost($title, $description, $userId)
    {
        $query = "Insert into posts(title, description, user_id, creation_time) values (?, ?, ?, ?);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$title, $description, $userId, (new DateTime())->format(Post::DATETIME_FORMAT)]);
    }
}