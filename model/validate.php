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
 * @return bool|array string representing error, or array constins true and sanitized datta
 */
function validName($data)
{
    $data=sanitizeTrim($data);
    //check if the string matches only alpha numeric
    if (ctype_alpha($data))
    {
        return array(true=>$data);
    }
    else
    {
        return "Invalid string numbers and special characters not allowed";
    }

}

/**
 * checks to see that an age is numeric and between 18 and 118
 * @param $data represent a phone number provided
 * @return array|string array of true and santizied value or error message to be used
 */
function validAge($data)
{
    $data=sanitizeTrim($data);
    //check is only numerical
    if(is_numeric($data) && ($data>17 && $data<118))
    {
        return array(true=>$data);
    }
    else
    {
        return "Invalid value must be numeric between 18 and 118";
    }

}

/**
 * Checks to see if matches phone number
 * @param $data phone number inputted
 * @return array|string array of true and santizied value or error message to be used
 */
function validPhone($data)
{
    $data=sanitizeTrim($data);
    if(preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $data))
    {
        return array(true=>$data);
    }
    else
    {
        return "Not a valid phone number. Phone number example 253-222-3333";
    }
}


function validEmail($data)
{
    $data = trim($data);
    if (filter_var($data, FILTER_VALIDATE_EMAIL))
    {
        return array(true => $data);
    } else {
        return "Not a valid email make sure email matches format. you2email.com";
    }
}
?>