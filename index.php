<?php
/**
 * @author Michael Britt
 * Date: 4/10/2019
 * A basic php index page calling the home page for a dating website
 * Includes the set up of our fate free framework
 */


//turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//require autoload file
require_once('vendor/autoload.php');

require_once('model/validate.php');
//create an instance of the base class
$f3 = Base::instance();

//session starts
session_start();

//state array
$states = array
(
    'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California','CO' => 'Colorado',
    'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District Of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia',
    'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
    'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts',
    'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana',
    'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico',
    'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
    'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota',
    'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington',
    'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
);

//Define a default route
$f3->route('GET /', function ()
{
    $view = new Template();
    echo $view->render('views/home.html');
}
);

//personal info route
$f3->route('GET|POST /personalInfo', function ($f3)
{
    $nameErr="error";
    if($_SERVER['REQUEST_METHOD'] =='POST')
    {
        //error array
        $arrayErr=array(
            "fnameErr"=>validName($_POST['fname']),
            "lnameErr"=>validName($_POST['lname']),
            "ageErr"=>validAge($_POST['age']),
            "genderErr"=>validGender($_POST['gender']),
            "phoneErr"=>validPhone($_POST['phone']) );

        //assign sessions if validate time and sanitize data if neccesarry
        if($arrayErr['fnameErr']=="") $_SESSION['fname'] = trimFilter($_POST[fname]);
        if($arrayErr['lnameErr']=="") $_SESSION['lname'] = trim($_POST[lname]);
        if($arrayErr['ageErr']=="") $_SESSION['age'] = trimFilter($_POST[age]);
        if($arrayErr['genderErr']=="")$_SESSION['gender'] = $_POST[gender];
        if($arrayErr['phoneErr']=="")$_SESSION['phone'] = trimFilter($_POST[phone]);


        //check error array is empty re-reoute to next page
        if(checkErrArray($arrayErr))
        {
            $f3->reroute('/profileEntry');
        }
        $f3->set('errors', $arrayErr);
    }
    $view = new Template();
    echo $view->render('views/personalInfo.html');
}
);

//profile enrty route
$f3->route('GET|POST /profileEntry', function ($f3) use ($states)
{
    if($_SERVER['REQUEST_METHOD'] =='POST')
    {
        //assemble error array
        $arrayErr=array(
            "emailErr"=>validEmail($_POST['email']),
            "stateErr"=>validateDropDown($_POST['state'], $states),
            "genderErr"=>validGender($_POST['seeking']));

        //assign sessions if validate trim and sanitize data if neccesarry
        if($arrayErr['emailErr']=="")$_SESSION['email'] = $_POST[email];
        if($arrayErr['stateErr']=="")$_SESSION['state'] = $_POST[state];
        if($arrayErr['genderErr']=="")$_SESSION['seeking'] = $_POST[seeking];
        $_SESSION['bio'] = trimFilter($_POST[bio]);

        //check if error free then re-route to next page
        if(checkErrArray($arrayErr))
        {
            $f3->reroute('/interest');
        }
        $f3->set('errors', $arrayErr);
    }
    $f3->set('states', $states);
    $view = new Template();
    echo $view->render('views/profileEntry.html');
}
);
//interests route
$f3->route('GET|POST /interest', function ($f3)
{

    //indoor array
    $indoor = array("tv" =>"Tv", "mov" => "Movies", "cook" => "Cooking", "board" => "Board-Games", "puzz" => "Puzzles",
    "read" => "Reading", "card" => "Playing-Cards", "video" => "Video-Games");

    //outdoor array
    $outdoor = array("hike" =>"Hiking", "bike" => "Biking", "swim" => "Swimming", "collect" => "Collecting",
        "walk" => "Walking", "climb" =>"Climbing");
    $activities="";
    if($_SERVER['REQUEST_METHOD'] =='POST')
    {
        //assemble errorArray
        $arrayErr=array(
            "indoor" =>validCheckBoxArray($_POST['indoor'], $indoor),
            "outdoot"=>validCheckBoxArray($_POST['outdoor'], $outdoor));

        //check if indoor is errors free then add to activities imploded array if valid
        if($arrayErr['indoor']=="")
        {
            if(isset($_POST[indoor]))
            {
                $activities .= implode(" ", $_POST[indoor]);
                $activities .= " ";
            }
            $_SESSION['indoor'] = $_POST[indoor];
        }

        if($arrayErr['outdoot']=="")
        {
            if(isset($_POST[outdoor]))
            {
                $activities.=implode(" ", $_POST[outdoor]);
            }
            $_SESSION['outdoor'] = $_POST[outdoor];
        }

        //activities is a imploded data of indoor and outdoor checkbox or empty if no checkboxes selected
        $_SESSION['interests'] = $activities;

        //check error array is empty
        if(checkErrArray($arrayErr))
        {
            $f3->reroute('/profileSummary');
        }
        $f3->set('errors', $arrayErr);
    }
    $f3->set('indoor', $indoor );
    $f3->set('outdoor', $outdoor);
    $view = new Template();
    echo $view->render('views/interests.html');
}
);

//profileSummary route
$f3->route('GET|POST /profileSummary', function ($f3)
{
    $view = new Template();
    echo $view->render('views/profileSummary.html');
}
);


//run fat free
$f3->run();


?>
