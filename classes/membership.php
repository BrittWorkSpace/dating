<?php

class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor takes First name, last name, age, gender and phone number.
     * @param string $fname The first name of the member
     * @param string $lname The last name of the member
     * @param int $age The age of the member
     * @param String $gender The gender of the member
     * @param String $phone The phone number of the member
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * Get the members first name
     * @return String fname The first name of the member
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Set the first name of the member
     * @param String $_fname
     * @return void
     */
    public function setFname($_fname)
    {
        $this->_fname = $_fname;
    }

    /**
     * Get the members last name
     * @return String Members last name
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Set the last name of a member
     * @param String $_lname
     * @return void
     */
    public function setLname($_lname)
    {
        $this->_lname = $_lname;
    }

    /**
     * Get the members age
     * @return int Members age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Set the members age
     * @param int $_age
     * @return void
     */
    public function setAge($_age)
    {
        $this->_age = $_age;
    }

    /**
     * Get the gender of the member
     * @return String Members gender
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Set the gender of a member
     * @param String $_gender
     * @return void
     */
    public function setGender($_gender)
    {
        $this->_gender = $_gender;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param mixed $_phone
     */
    public function setPhone($_phone)
    {
        $this->_phone = $_phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $_email
     */
    public function setEmail($_email)
    {
        $this->_email = $_email;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param mixed $_state
     */
    public function setState($_state)
    {
        $this->_state = $_state;
    }

    /**
     * @return mixed
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * @param mixed $_seeking
     */
    public function setSeeking($_seeking)
    {
        $this->_seeking = $_seeking;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param mixed $_bio
     */
    public function setBio($_bio)
    {
        $this->_bio = $_bio;
    }

}