<?php

class user
{
    private $conn;
    private $table_name = "user";

    public $userId;
    public $name;
    public $email;
    public $password;
//    public $created;
//    public $conform_password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readUser()
    {

        $query = " select * from user ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

    }

    public function createUser()
    {

        // query to insert record
        $query = "insert into user set name=:name, email=:email, password=:password";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;

    }

    public function update()
    {

        // query to insert record
        $query = "update user set name=:name, email=:email, password=:password where userId=:userId";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->userId=htmlspecialchars(strip_tags($this->userId));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":userId", $this->userId);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;

    }

}