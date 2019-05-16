<?php

/*  Table creation code
CREATE TABLE member
(
    member_id int PRIMARY KEY AUTO_INCREMENT,
	fname varchar(255) not null,
    lname varchar(255) not null,
    age int(3),
    gender char(1),
    phone varchar(13),
    email varchar(350),
    state char(2),
    seeking char(1),
    bio varchar(500),
    premium tinyint,
    image varchar(260)
);


CREATE TABLE interest
(
    interest_id int PRIMARY KEY AUTO_INCREMENT,
    interest varchar(100),
    type varchar(30)
);


CREATE TABLE memberinterest
(
    interest_id int,
    member_id int,
    FOREIGN KEY (interest_id) REFERENCES inserest(interest_id),
    FOREIGN KEY (member_id) REFERENCES member(member_id),
    PRIMARY KEY (interest_id, member_id)
);
*/
require '/home2/mbrittgr/config.php';

Class database
{
    private $dbh;

    public function connect()
    {
        try{
            $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD
            );
            return $dbh;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return $dbh="";
        }
    }

    public function insertMember($member)
    {
        $dbh = $this->connect();
        if(isset($dbh)){
            $sql = "INSERT INTO members(fname, lname, age, gender, phone, email, state, seeking, bio, premium) 
                VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";
            $fname = $member->getFname();
            $lname = $member->getLname();
            $age = $member->getAge();
            $gender = $member->getGender();
            $phone = $member->getPhone();
            $state = $member->getState();
            $seeking = $member->getSeeking();


            $statement = $dbh->prepare($sql);
            $statement->bindParam(':fname',$fname, PDO::PARAM_STR);
            $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
            $statement->bindParam(':age', $age, PDO::PARAM_INT);
            $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
            $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':state', $state, PDO::PARAM_STR);
            $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
            $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
            $statement->bindParam(':premium', $premium, PDO::PARAM_STR);
        }
    }

    public function getMembers()
    {

    }

    public function getMember($member_id)
    {

    }

    public function getInterests($member_id)
    {

    }
}