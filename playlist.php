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

// get the q parameter from URL
$q = $_REQUEST["q"];

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
switch ($q)
{
    case "Acadie":
        UpdatePlaylist("Acadie", PLAYLIST_ACADIE, LIBRARY_ACADIE);
        break;
    case "Baseball":
        UpdatePlaylist("Baseball", PLAYLIST_BASEBALL, LIBRARY_BASEBALL);
        break;
    case "Christian":
        UpdatePlaylist("Christian", PLAYLIST_CHRISTIAN, CLASSICS_CHRISTIAN);
        break;
    case "CountrySoul":
        UpdatePlaylist("Country/Soul", PLAYLIST_COUNTRYSOUL, LIBRARY_COUNTRYSOUL);
        break;
    case "Heartland":
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND, CLASSICS_HEARTLAND);
        break;
    case "Heartland2":
        UpdatePlaylist("Heartland", PLAYLIST_HEARTLAND2, CLASSICS_HEARTLAND);
        break;
    case "Francofolk":
        UpdatePlaylist("FrancoFolk", PLAYLIST_FRANCOFOLK, LIBRARY_FRANCOFOLK);
        break;
    case "Nicole":
        UpdatePlaylist("Nicole", PLAYLIST_NICOLE, CLASSICS_NICOLE);
        break;
    case "Phil":
        UpdatePlaylist("Phil", PLAYLIST_PHIL, CLASSICS_PHIL);
        break;
}
// Save the Refresh Token to a file
SaveToFile(FILE_TOKEN, $session->getRefreshToken());
?> 