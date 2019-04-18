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


//create an instance of the base class
$f3 = Base::instance();

//session starts
session_start();

//state array
$states = array(
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
$f3->route('GET|POST /personalInfo', function ()
{
    $view = new Template();
    echo $view->render('views/personalInfo.html');
}
);

//profile enrty route
$f3->route('GET|POST /profileEntry', function ($f3) use ($states) {
    $_SESSION['fname'] = $_POST[fname];
    $_SESSION['lname'] = $_POST[lname];
    $_SESSION['age'] = $_POST[age];
    $_SESSION['gender'] = $_POST[gender];
    $_SESSION['phone'] = $_POST[phone];

    $f3->set('states', $states);
    $view = new Template();
    echo $view->render('views/profileEntry.html');
}
);
//interests route
$f3->route('GET|POST /interests', function ($f3)
{
    $_SESSION['email'] = $_POST[email];
    $_SESSION['state'] = $_POST[state];
    $_SESSION['seeking'] = $_POST[seeking];
    $_SESSION['bio'] = $_POST[bio];

    $f3->set('indoor', array("tv" =>"Tv", "mov" => "Movies", "cook" => "Cooking", "board" => "Board Games", "puzz" => "Puzzles",
        "read" => "Reading", "card" => "Playing cards", "video" => "Video Games"));
    $f3->set('outdoor', array("hike" =>"Hiking", "bike" => "Biking", "swim" => "Swimming", "collect" => "Collecting",
    "walk" => "Walking", "climb" =>"Climbing"));
    $view = new Template();
    echo $view->render('views/interests.html');
}
);

//profileSummary route
$f3->route('GET|POST /profileSummary', function ($f3)
{
    $_SESSION['indoor'] = $_POST[indoor];
    $_SESSION['outdoor'] = $_POST[outdoor];
    print_r($_SESSION);
    $view = new Template();
    echo $view->render('views/profileSummary.html');
}
);


//run fat free
$f3->run();


?>
