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
        } catch (PDOException $e)
        {
            echo $e->getMessage();
            return $dbh="";
        }
    }

    public function insertMember($member)
    {
        $dbh = $this->connect();
        if(isset($dbh)){
            //prepare sql statement
            $sql = "INSERT INTO members(fname, lname, age, gender, phone, email, state, seeking, bio, premium) 
                VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";
            //save prepared statement
            $statement = $dbh->prepare($sql);

            //assign values
            $fname = $member->getFname();
            $lname = $member->getLname();
            $age = $member->getAge();
            $gender = $member->getGender();
            $phone = $member->getPhone();
            $state = $member->getState();
            $seeking = $member->getSeeking();

            //bind params
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

            //execute insert into member
            $statement->execute();

            //grab id of insert
            $id = $dbh->lastInsertId();

            //check if Premium member to insert
            if($member instanceof Member_Premium) {
                insertInterest($member->getIndoorInterest(), $id, $dbh);
                insertInterest($member->getOutDoorInterests(), $id, $dbh);
            }
        }
    }

    private function getInterestID($interest)
    {
        $dbh = $this->connect();
        if(isset($dbh)){
            $sql = "SELECT interest_id FROM interest WHERE interest = :interest";
            $statement = $dbh->prepare($sql);
            $statement->bindParam(':interest', $interest, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['interest_id'];
        }
    }

    private function insertInterest($array,$id,$dbh)
    {
        $sql = "INSERT INTO memberinterest(interest_id, member_id) VALUES (:interest, :member)";
        $statement = $dbh->prepare($sql);

        //for each indoor interest bind and execute statemnt
        foreach ($array as $value) {
            //bind interest id and member id
            $statement->bindParam(":interest", $this->getInterestID($value),
                PDO::PARAM_INT);
            $statement->bindParam(":member", $id, PDO::PARAM_INT);

            //execute
            $statement->execute();
        }
    }

    public function getMembers()
    {
        $dbh = $this->connect();
        $sql = "SELECT * FROM members";
        $statement = $dbh->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMember($member_id)
    {
        $dbh = $this->connect();
        $sql = "SELECT * FROM members WHERE member_id = :id";
        $statement = $dbh->prepare($sql);

        $statement->bindParam(":id", $member_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getInterests($member_id)
    {

    }
}