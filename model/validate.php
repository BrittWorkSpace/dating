<?php
/**
 * @ Michael Britt
 * Date 4/15/19
 * Functions that validate form data
 * vesion 1.0
 */

/**
 * Santize and check string for alphabetical
 * @param $data Represents string form data for names
 * @return string empty string if no errors or error message
 */
function validName($data)
{

    //check if the string matches only alpha numeric
    if (ctype_alpha($data)) {
        return "";
        //return array(true=>$data);
    } else {
        return "Invalid string. Contains numbers, special characters, or is empty.";
    }

}

/**
 * checks to see that an age is numeric and between 18 and 118
 * @param $data represent a phone number provided
 * @return string empty string if no errors or error message
 */
function validAge($data)
{
    //check is only numerical
    if(is_numeric($data) && ($data>17 && $data<119)) {
        return "";
    } else {
        return "Invalid value must be numeric between 18 and 118";
    }

}

/**
 * Checks to see if matches phone number
 * @param $data phone number inputted
 * @return string empty string if no errors or error message
 */
function validPhone($data)
{
    if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $data)) {
        return "";
    } else {
        return "Not a valid phone number. Phone number example 253-222-3333";
    }
}

/**
 * Checks if email provided is a valid email
 * @param $data email provided
 * @return string empty string if no errors or error message
 */
function validEmail($data)
{
    $data = trim($data);
    if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
        return "";
    } else {
        return "Invalid email. Please enter email in format You@email.com";
    }
}

/**
 * Validates that values of checkboxes selected match original check boxes values
 * @param $data checkboxes selected values
 * @return string empty string if no errors or error message
 */
function validCheckBoxArray($data , $array)
{
    if($data!=null) {
        foreach ($data as $key=>$value) {
            if (!in_array($value, $array)) {
                return "Improper value provided. Provided value does not match checkboxes provided";
            }
        }
        return "";
    }
    return "";
}

/**
 * Checks that gender only has m or female selected
 * @param $data posted value of radio button
 * @return string empty string if no errors or error message
 */
function validGender($data)
{
    if($data=='M' || $data =='F' || !isset($data)) {
        return"";
    } else {
        return "Invalid value returned.";
    }
}

/**
 * Returns a trimmed and sanatized string
 * @param $data string provided
 * @return mixed string stripped of special characters and trimed
 */
function trimFilter($data)
{
    return filter_var(trim($data), FILTER_SANITIZE_STRING);
}

/**
 * validates a dropdown posted value returns a value inside its array
 * @param $data posted value for dropdown
 * @param $dropDownArray array of values for dropdown
 * @return bool if value is in array
 */
function validateDropDown($data, $dropDownArray)
{
    if(in_array($data, $dropDownArray, TRUE))
    {
        return "";
    }
    return "No dropdown value selected or value is invalide";
}
/**
 * Checks an error array has no set values if so no errors exist
 * @param $data error array
 * @return bool true:no errors, false:errors exist
 */
function checkErrArray($data)
{
    foreach ($data as $key => $value) {
        if($value!="") {
            return false;
        }
    }
    return true;
}
?>