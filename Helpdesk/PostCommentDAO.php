<?php

include "PostComment.php";

class PostCommentDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // public function findById($id) {
    //     $stmt = $this->pdo->prepare('SELECT * FROM post_comments WHERE id = ?;');
    //     $stmt->execute([$id]);
    //     $row = $stmt->fetch();
    //     if (!$row) {
    //         return null;
    //     }
    //     return new Post($row['description'], $row['title'], $row['creation_time'], $row['id']);
    // }

    public function findAllById($id) {
        $stmt = $this->pdo->prepare('SELECT post_comments.description, post_comments.post_id, post_comments.creation_time, post_comments.id, users.username FROM post_comments JOIN users on users.id=user_id WHERE post_id = ? ORDER BY id ASC;');
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll();
        $comments = [];
        $commentsRow = [];
        foreach($rows as $row)
        {
            $comment = new PostComment($row["description"], $row["post_id"], $row["username"], $row["creation_time"], $row["id"]);
            $commentsRow[] = $row;
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function createComment($description, $postId, $userId)
    {
        $query = "Insert into post_comments(description, user_id, post_id) values (?, ?, ?);";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$description, $userId, $postId]);
    }
}