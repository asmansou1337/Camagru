<?php

class Picture {
    /*private $picId;
    private $name;
    private $img_path;
    private $creation_date;
    private $userId;
    private $username;
    private $firstName;
    private $lastName;
    private $email;
    private $notify;
    private $countLikes;
    private $countComments;
    private $isLiked;*/

   /* public function __construct(){}

    /*public function __construct($id, $name, $path, $creationDate, $ownerId, $ownerUsername,$ownerFirstName, $ownerLastName, $ownerEmail, $ownerNotify, $countLikes, $countComments, $isLiked) {
        $this->setId($id);
        $this->setName($name);
        $this->setPath($path);
        $this->setCreationDate($creationDate);
        $this->setOwnerId($ownerId);
        $this->setOwnerUsername($ownerUsername);
        $this->setOwnerFirstName($ownerFirstName);
        $this->setOwnerLastName($ownerLastName);
        $this->setOwnerEmail($ownerEmail);
        $this->setOwnerNotify($ownerNotify);
        $this->setCountLikes($countLikes);
        $this->setCountComments($countComments);
        $this->setIsLiked($isLiked);
    }*/

    /*public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function setOwnerUsername($ownerUsername)
    {
        $this->ownerUsername = $ownerUsername;
    }

    public function setOwnerFirstName($ownerFirstName)
    {
        $this->ownerFirstName = $ownerFirstName;
    }

    public function setOwnerLastName($ownerLastName)
    {
        $this->ownerLastName = $ownerLastName;
    }

    public function setOwnerEmail($ownerEmail)
    {
        $this->ownerEmail = $ownerEmail;
    }

    public function setOwnerNotify($ownerNotify)
    {
        $this->ownerNotify = $ownerNotify;
    }

    public function setCountLikes($countLikes)
    {
        $this->countLikes = $countLikes;
    }

    public function setCountComments($countComments)
    {
        $this->countComments = $countComments;
    }

    public function setIsLiked($isLiked)
    {
        $this->isLiked = $isLiked;
    }*/

   
    public function getId()
    {
       return $this->picId;
    }

    public function getPath()
    {
        return $this->img_path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function getOwnerId()
    {
        return $this->userId;
    }

    public function getOwnerUsername()
    {
        return $this->username;
    }

    public function getOwnerFirstName()
    {
        return $this->firstName;
    }

    public function getOwnerLastName()
    {
        return $this->lastName;
    }

    public function getOwnerEmail()
    {
        return $this->email;
    }

    public function getOwnerNotify()
    {
        return $this->notify;
    }

    public function getCountLikes()
    {
        return $this->countLikes;
    }

    public function getCountComments()
    {
        return $this->countComments;
    }

    public function getIsLiked()
    {
        return $this->isLiked;
    }

}

?>