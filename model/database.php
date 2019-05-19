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

/**
 * @author Michael Britt
 * @version 1.0
 * Date: 5/18/2019
 * Class database connects to database for dating website, inserts members, inserts interests
 */
Class database
{
    private $dbh;

    /**
     * database constructor. Start out disconnected
     */
    public function __construct()
    {
        #this->dbh="Not connected";

    }

    /**
     * Attempts to connect to database, saves error message if not connected
     * @return void
     */
    public function connect()
    {
        try{
            $this->dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD
            );
        } catch (PDOException $e)
        {
            $this->dbh = $e->getMessage();

        }
    }

    /**
     * Inserts a member into database
     * @param $member A membership object
     * @return void
     */
    public function insertMember($member)
    {
        if(isset($this->dbh)){
            //prepare sql statement
            $sql = "INSERT INTO member(fname, lname, age, gender, phone, email, state, seeking, bio, premium) 
                VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";
            //save prepared statement
            $statement = $this->dbh->prepare($sql);

            //assign values
            $fname = $member->getFname();
            $lname = $member->getLname();
            $age = $member->getAge();
            $gender = $member->getGender();
            $phone = $member->getPhone();
            $state = $member->getState();
            $seeking = $member->getSeeking();
            $email = $member->getEmail();
            $bio = $member->getBio();
            if($member instanceof  Member_Premium)
            {
                $premium =1;
            }
            else
            {
                $premium=0;
            }

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
            $statement->bindParam(':premium', $premium, PDO::PARAM_INT);

            //execute insert into member
            $statement->execute();

            //grab id of insert
            $id = $this->dbh->lastInsertId();

            //check if Premium member to insert
            if($member instanceof Member_Premium) {
                $indoor=$member->getInDoorInterests();
                $outdoor=$member->getOutDoorInterests();
                if(isset($indoor))
                {
                    $this->insertInterest($indoor, $id);
                }
                if(isset($outdoor))
                {
                    $this->insertInterest($outdoor, $id);
                }

            }
        }
    }

    /**
     * Checks db for interest and returns its id
     * @param $interest String interests name
     * @return Int interest id
     */
    private function getInterestID($interest)
    {
        if(isset($this->dbh)){
            $sql = "SELECT interest_id FROM interest WHERE interest = :interest";
            $statement = $this->dbh->prepare($sql);
            $statement->bindParam(':interest', $interest, PDO::PARAM_STR);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['interest_id'];
        }
    }

    /**
     * Takes an array of interests and inserts them into db with member id
     * @param $array interest array
     * @param $id Int db members id
     */
    private function insertInterest($array,$id)
    {
        $sql = "INSERT INTO memberinterest(interest_id, member_id) VALUES (:interest, :member)";
        $statement = $this->dbh->prepare($sql);

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

    /**
     * Retrieves all members from the database
     * @return Array the result of the database retrieval
     */
    public function getMembers()
    {
        $sql = "SELECT * FROM member ORDER BY lname ASC";
        $statement = $this->dbh->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a specific member from the database
     * @param $member_id The id of the member to be retrieved
     * @return Array The result of the sql query
     */
    public function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id = :id";
        $statement = $this->dbh->prepare($sql);

        $statement->bindParam(":id", $member_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets the interests of a specific member of the database
     * @param $member_id The id of the member to retrieved
     * @return String Interests imploded into a string
     */
    public function getInterests($member_id)
    {
        $sql = "SELECT * FROM memberinterest WHERE member_id = :id";
        $statement = $this->dbh->prepare($sql);

        $statement->bindParam(":id", $member_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $intrestArray= array();
        if (isset($result)) {
            foreach ($result as $value) {
                array_push( $intrestArray, $this->getInterestString($value['interest_id']));
            }

            return implode(", ", $intrestArray);
        }else{
            return "";
        }
    }

    /**
     * Returns a String of the interest
     * @param $interest_id The id of an interest from the interest table
     * @return String interest name as a string
     */
    private function getInterestString($interest_id)
    {
        $sql = "SELECT * FROM interest WHERE interest_id = :id";
        $statement = $this->dbh->prepare($sql);

        $statement->bindParam(":id", $interest_id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['interest'];
    }
}