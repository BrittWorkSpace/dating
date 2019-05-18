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
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        //error array
        $arrayErr=array(
            "fnameErr"=>validName($_POST['fname']),
            "lnameErr"=>validName($_POST['lname']),
            "ageErr"=>validAge($_POST['age']),
            "genderErr"=>validGender($_POST['gender']),
            "phoneErr"=>validPhone($_POST['phone']) );

        //check error array is empty re-reoute to next page
        if(checkErrArray($arrayErr)) {
            if(isset($_POST[prem])) {
                $_SESSION['member'] = new Member_Premium(trimFilter($_POST[fname]),trim($_POST[lname]),trimFilter($_POST[age]),
                    $_POST[gender],trimFilter($_POST[phone]) );
            }else{
                $_SESSION['member'] = new Member(trimFilter($_POST[fname]),trim($_POST[lname]),trimFilter($_POST[age]),
                    $_POST[gender],trimFilter($_POST[phone]) );
            }
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
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        //assemble error array
        $arrayErr=array(
            "emailErr"=>validEmail($_POST['email']),
            "stateErr"=>validateDropDown($_POST['state'], $states),
            "genderErr"=>validGender($_POST['seeking']));

        //check if error free then re-route to next page
        if(checkErrArray($arrayErr)){
            //assign sessions if validate trim and sanitize data if neccesarry
            $_SESSION['member']->setEmail($_POST[email]);
            $_SESSION['member']->setState($_POST[state]);
            $_SESSION['member']->setSeeking($_POST[seeking]);
            $_SESSION['member']->setBio($_POST[bio]);
            if($_SESSION['member'] instanceof Member_Premium){
                $f3->reroute('/interest');
            }else{
                //istantiate a db object
                $database = new database();
                $database->connect();
                //insert member
                $database->insertMember($_SESSION['member']);
                $f3->reroute('/profilesummary');
            }
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

    if($_SERVER['REQUEST_METHOD'] =='POST') {
        //assemble errorArray
        $arrayErr=array(
            "indoor" =>validCheckBoxArray($_POST['indoor'], $indoor),
            "outdoot"=>validCheckBoxArray($_POST['outdoor'], $outdoor));

        //check error array is empty
        if(checkErrArray($arrayErr)) {
            $_SESSION['member']->setIndoorInterests($_POST['indoor']);
            $_SESSION['member']->setOutDoorInterests($_POST['outdoor']);

            //istantiate a db object
            $database = new database();
            $database->connect();
            //insert member
            $database->insertMember($_SESSION['member']);


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
    $activities="";
    if($_SESSION['member'] instanceof Member_Premium){
        $ind= $_SESSION['member']->getInDoorInterests();
        $out= $_SESSION['member']->getOutDoorInterests();
        //check if indoor is errors free then add to activities imploded array if valid
        if(isset($ind)) {
            $activities .= implode(" ", $ind);
            $activities .= " ";
        }
        if(isset($out)){
            $activities.=implode(" ", $ind);
        }
    }
    $f3->set('activities', $activities);
    $view = new Template();
    echo $view->render('views/profileSummary.html');
}
);


$f3->route('GET /admin', function ($f3)
{

    $view = new Template();
    echo $view->render("views/admin.html");
}
);
//run fat free
$f3->run();
?>
