<?php

class PostComment
{
    private $id;
    private $description;
    private $post_id;
    private $create_time;
    private $author_name;

    private const DATETIME_FORMAT = "Y-m-d\TH:i:s";

    function __construct($description, $post_id, $authorName, $create_time = null, $id = null)
    {
        if(is_null($create_time))
            $create_time = new DateTime();
        $this->post_id = $post_id;
        $this->description = $description;
        $this->create_time = $create_time;
        $this->author_name = $authorName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function setCreateTime(DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}