<?php

class Post
{
    private $id;
    private $description;
    private $title;
    private $user_id;
    private $author_name;
    private $create_time;

    public const DATETIME_FORMAT = "Y-m-d\TH:i:s";

    function __construct($description, $title, $create_time = null, $id = null, $userId, $author_name)
    {
        if(is_null($create_time))
            $create_time = new DateTime();
        $this->title = $title;
        $this->description = $description;
        $this->create_time = $create_time;
        $this->user_id = $userId;
        $this->author_name = $author_name;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getTitle()
    {
        return $this->title;
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

    public function getCreateTimeString()
    {
        return $this->create_time->format(self::DATETIME_FORMAT);
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}