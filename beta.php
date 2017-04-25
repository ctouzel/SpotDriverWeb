<?php

//
// CONFIGURATION
//
date_default_timezone_set('America/New_York');
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('memory_limit', '1024M');

//
// INCLUDES
//
include("constants_spotdriver.php");
include("utils.php");
include("spotify_utils.php");
include("Session.php");
include("SpotifyWebAPI.php");
include("SpotifyWebAPIException.php");

//
// SPOTDRIVER WEB START 
//

// HEADER
echo "<!DOCTYPE html>".PHP_EOL;
echo "<html xmlns='http://www.w3.org/1999/xhtml'>".PHP_EOL;
echo "<head>".PHP_EOL;
echo "<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"UTF-8\" />".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"spotdriver.css\">".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic,900italic|Droid+Serif:400,700,400italic,700italic\">".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=Cabin\">".PHP_EOL;
echo "<link rel=\"icon\" href=\"favicon.ico\">".PHP_EOL;
echo "<title>".TITLE." - BETA</title>".PHP_EOL;
echo "</head>".PHP_EOL;
echo "<body><header>".PHP_EOL;
echo "<div class=\"nav\"><ul>".PHP_EOL;
echo "<li class=\"home\"><a href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a class=\"active\" href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header><p>&nbsp;</p>".PHP_EOL;

echo "<div id=\"wrapper\">";
echo "<h1>".TITLE." ".VERSION." - BETA</h1>".PHP_EOL;
echo "</div><p>&nbsp;</p>";

// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();

$refreshToken = ReadFromFile(FILE_TOKEN);
$session->refreshAccessToken($refreshToken);
$GLOBALS['api']->setAccessToken($session->getAccessToken());

// UPDATE PLAYLISTS
echo "<div id=\"wrapper\" style=\"font-size: 1.7em;\">";
echo "<h1>Beta Update</h1>";
UpdatePlaylist("Phil", PLAYLIST_PHIL, CLASSICS_PHIL);
UpdatePlaylist("Simon", PLAYLIST_SIMON, CLASSICS_SIMON);


echo "</div><p>&nbsp;</p>";


// Save the Refresh Token to a file
SaveToFile(FILE_TOKEN, $session->getRefreshToken());

echo "</body></html>";

//
// SPOTDRIVER WEB END 
//


/******* **************************************  *******
               SPOTDRIVER WEB FUNCTIONS
 ******* **************************************  *******/




?>

 
