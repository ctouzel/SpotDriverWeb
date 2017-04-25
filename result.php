<?php

//
// CONFIGURATION
//
date_default_timezone_set('America/Montreal');
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
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style_spotdriver.css\">".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic,900italic|Droid+Serif:400,700,400italic,700italic\">".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=Cabin\">".PHP_EOL;
echo "<link rel=\"icon\" href=\"favicon.ico\">".PHP_EOL;
echo "<title>".TITLE."</title>".PHP_EOL;
echo "</head>".PHP_EOL;
echo "<body><header>".PHP_EOL;
echo "<div class=\"nav\"><ul>".PHP_EOL;
echo "<li class=\"home\"><a class=\"active\" href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header><p>&nbsp;</p>".PHP_EOL;

echo "<div id=\"wrapper\">";
echo "<h1>".TITLE." ".VERSION."</h1>".PHP_EOL;
echo "</div><p>&nbsp;</p>";

// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();
if(isset($_GET['code'])) 
{
    $session->requestAccessToken($_GET['code']);
	$GLOBALS['api']->setAccessToken($session->getAccessToken());
}
else
{
	$refreshToken = ReadFromFile(FILE_TOKEN);
	$session->refreshAccessToken($refreshToken);
	$GLOBALS['api']->setAccessToken($session->getAccessToken());
}

// SCHEDULED PLAYLIST UPDATES
echo "<div id=\"wrapper\" style=\"font-size: 1.7em;\">";
echo "<h1>Playlists Update</h1>";

switch (date("l")) 
{
    case "Sunday":
        UpdatePlaylist("WCRY - Country/Soul Radio", PLAYLIST_COUNTRYSOUL, LIBRARY_COUNTRYSOUL);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdateClassics("Christian", USER_CHRIS, TOP_SONGS_CHRISTIAN, CLASSICS_CHRISTIAN);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND2, CLASSICS_HEARTLAND);
        UpdatePlaylist("WSOL - Latin Radio", PLAYLIST_LATIN, LIBRARY_LATIN);
        UpdatePlaylist("WMAX - Max Fun Radio", PLAYLIST_FUN, LIBRARY_FUN);
        break;
    case "Monday":
        UpdatePlaylist("Acadie", PLAYLIST_ACADIE, LIBRARY_ACADIE);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdatePlaylist("Christian", PLAYLIST_CHRISTIAN, CLASSICS_CHRISTIAN);
        UpdateClassics("Philippe", USER_PHIL, TOP_SONGS_PHIL, CLASSICS_PHIL);
        UpdatePlaylist("ChristianPlus", PLAYLIST_CHRISTIAN_PLUS, CLASSICS_CHRISTIAN);
        UpdatePlaylist("WHAY - Folk Radio", PLAYLIST_FOLK, LIBRARY_FOLK);
        UpdatePlaylist("WFIX - Smash Radio", PLAYLIST_SMASH, LIBRARY_SMASH);
        break;
    case "Tuesday":
        UpdatePlaylist("WMUG - Coffee Shop Radio", PLAYLIST_COFFEESHOP, LIBRARY_COFFEESHOP);
        UpdatePlaylist("WSIX - Dylan Radio", PLAYLIST_1968, LIBRARY_1968);
        UpdatePlaylist("WDIG - Cool Radio", PLAYLIST_COOL, LIBRARY_COOL);
        UpdatePlaylist("WMAD - Portland Radio", PLAYLIST_PORTLAND, LIBRARY_PORTLAND);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdateClassics("Simon", USER_SIMON, TOP_SONGS_SIMON, CLASSICS_SIMON);
        break;
    case "Wednesday":
        UpdatePlaylist("WROC - Dirty Rock Radio", PLAYLIST_DIRTYROCK, LIBRARY_DIRTYROCK);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdatePlaylist("Christian", PLAYLIST_CHRISTIAN, CLASSICS_CHRISTIAN);
        UpdatePlaylist("ChristianPlus", PLAYLIST_CHRISTIAN_PLUS, CLASSICS_CHRISTIAN);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND2, CLASSICS_HEARTLAND);
        UpdatePlaylist("WCAP - Baseball Radio", PLAYLIST_BASEBALL, LIBRARY_BASEBALL);
        break;
    case "Thursday":
        UpdatePlaylist("WSUN - Desert Rock Radio", PLAYLIST_DESERTROCK, LIBRARY_DESERTROCK);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdatePlaylist("Christian", PLAYLIST_CHRISTIAN, CLASSICS_CHRISTIAN);
        UpdatePlaylist("Couple", PLAYLIST_COUPLE, CLASSICS_CHRISTIAN);
        UpdatePlaylist("ChristianPlus", PLAYLIST_CHRISTIAN_PLUS, CLASSICS_CHRISTIAN);
        UpdatePlaylist("WLAB - Lab Radio", PLAYLIST_LAB, LIBRARY_LAB);
        break;
    case "Friday":
        UpdatePlaylist("Party", PLAYLIST_PARTY, LIBRARY_PARTY);
        UpdatePlaylist("Simon", PLAYLIST_SIMON, CLASSICS_SIMON);
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        UpdateClassics("Nicole", USER_CHRIS, TOP_SONGS_NICOLE, CLASSICS_NICOLE);
        UpdatePlaylist("ChristianPlus", PLAYLIST_CHRISTIAN_PLUS, CLASSICS_CHRISTIAN);
        UpdatePlaylist("WBUZ - Buzz Radio", PLAYLIST_BUZZ, LIBRARY_BUZZ);
        UpdatePlaylist("WSON - Buena Vista Radio", PLAYLIST_BUENA, LIBRARY_BUENA);
        break;
    case "Saturday":
        UpdatePlaylist("WQBC - FrancoFolk Radio", PLAYLIST_FRANCOFOLK, LIBRARY_FRANCOFOLK);
        UpdatePlaylist("Phil", PLAYLIST_PHIL, CLASSICS_PHIL);
        UpdatePlaylist("Nicole", PLAYLIST_NICOLE, CLASSICS_NICOLE);
        UpdateClassics("Heartland", USER_CHRIS, TOP_SONGS_HEARTLAND, CLASSICS_HEARTLAND);
        UpdatePlaylist("WSKY - Oldfield Radio", PLAYLIST_OLDFIELD, LIBRARY_OLDFIELD);
        UpdatePlaylist("WGUN - Outlaw Radio", PLAYLIST_OUTLAW, LIBRARY_OUTLAW);
        break;
}

// CHRISTMAS PLAYLIST CHECK
if ((date("F") == "November" && date("j") > 13) || (date("F") == "December" && date("j") < 26))
{
	UpdatePlaylist("Christmas", PLAYLIST_CHRISTMAS, LIBRARY_CHRISTMAS);
}

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

 
