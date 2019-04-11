<?php
/**
 * @author Michael Britt
 * Date: 2/7/2019
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
    echo $view->render('views/personalInfo.php');
}
);

//profile enrty route
$f3->route('GET|POST /profileEntry', function ()
{
    $view = new Template();
    echo $view->render('views/profileEntry.php');
}
);
//interests route
$f3->route('GET|POST /interests', function ($f3)
{
    $f3->set('indoor', array("tv" =>"Tv", "mov" => "Movies", "cook" => "Cooking", "board" => "Board Games", "puzz" => "Puzzles",
        "read" => "Reading", "card" => "Playing cards", "video" => "Video Games"));
    $f3->set('outdoor', array("hike" =>"Hiking", "bike" => "Biking", "swim" => "Swimming", "collect" => "Collecting",
    "walk" => "Walking", "climb" =>"Climbing"));
    $view = new Template();
    echo $view->render('views/interests.php');
}
);

//profileSummary route
$f3->route('GET|POST /profileSummary', function ()
{
    $view = new Template();
    echo $view->render('views/profileSummary.php');
}
);


//run fat free
$f3->run();


?>
