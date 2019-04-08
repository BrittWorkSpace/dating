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
        $view = new View;
        echo $view->render('views/home.html');
    }
);

//personal info route
$f3->route('GET /personalInfo', function ()
{
    $view = new View;
    echo $view->render('views/personalInfo.html');
}
);

//profile enrty route
$f3->route('GET /profileEntry', function ()
{
    $view = new View;
    echo $view->render('views/profileEntry.html');
}
//interests route
);
$f3->route('GET /interests', function ()
{
    $view = new View;
    echo $view->render('views/interests.html');
}
);

//profileSummary route
$f3->route('GET /profileSummary', function ()
{
    $view = new View;
    echo $view->render('views/profileSummary.html');
}
);


//run fat free
$f3->run();


?>
