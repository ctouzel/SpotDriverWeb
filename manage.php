<?php

//
// CONFIGURATION
//
date_default_timezone_set('America/Montreal');
error_reporting(-1);
ini_set('display_errors', 1);

//
// INCLUDES
//
include("constants_spotdriver.php");
include("utils.php");
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
echo "<link rel=\"icon\" href=\"favicon.ico\">".PHP_EOL;
echo "<title>".TITLE."</title>".PHP_EOL;
echo "<script>".PHP_EOL;
echo "function removealbum(p1) {".PHP_EOL;
echo "        var xmlhttp = new XMLHttpRequest();".PHP_EOL;
echo "        xmlhttp.onreadystatechange = function() {".PHP_EOL;
echo "            if (this.readyState == 4 && this.status == 200) {".PHP_EOL;
echo "                document.getElementById(\"txtHint\").innerHTML = this.responseText;".PHP_EOL;
echo "            }".PHP_EOL;
echo "        };".PHP_EOL;
echo "        xmlhttp.open(\"GET\", \"manager.php?q=\"+p1+\"\" , true);".PHP_EOL;
echo "        xmlhttp.send();".PHP_EOL;
echo "}".PHP_EOL;
echo "</script>".PHP_EOL;
echo "</head>".PHP_EOL;
echo "<body><header>".PHP_EOL;
echo "<div class=\"nav\"><ul>".PHP_EOL;
echo "<li class=\"home\"><a href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a class=\"active\" href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header><p>&nbsp;</p>".PHP_EOL;

echo "<div id=\"wrapper\">";
echo "<h1>Profile Management</h1>".PHP_EOL;
echo "</div><p>&nbsp;</p>";

// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();
$refreshToken   = ReadFromFile(FILE_TOKEN);
$session->refreshAccessToken($refreshToken);
$GLOBALS['api']->setAccessToken($session->getAccessToken());

GetSavedAlbums();

echo "<h1>Result</h1>";
echo "<p style='font-size:2.2em'><span id=\"txtHint\"></span></p>";

// Save the Refresh Token to a file
SaveToFile(FILE_TOKEN, $session->getRefreshToken());

echo "</body></html>";

//
// SPOTDRIVER WEB END 
//



/******* **************************************  *******
               SPOTDRIVER WEB FUNCTIONS
 ******* **************************************  *******/

//
// GET ARTISTS STRING
//
function GetArtistsString($artists)
{
    $artistsString = "";
    if (count($artists) == 1)
    {
        $artistsString = $artists[0]->name;
    }
    else if (count($artists) == 2)
    {
        $artistsString = $artists[0]->name . ', ' . $artists[1]->name;
    }
    else if (count($artists) == 3)
    {
        $artistsString = $artists[0]->name . ', ' . $artists[1]->name . ', '. $artists[2]->name;
    }
    else
    {
        $artistsString = $artists[0]->name . ', ' . $artists[1]->name . ' & more';
    }  
    return $artistsString;
}

//
// GET SAVED ALBUMS
//
function GetSavedAlbums()
{
    $saved = $GLOBALS['api']->getMySavedAlbums();

    echo "<div id=\"wrapper\">";
    echo "<h1>Saved Albums</h1>";
    echo "<table id=\"keywords\" cellspacing=\"0\" cellpadding=\"0\">";
    echo "<thead><tr><th><span>Artists</span></th><th><span>Album</span></th>";
    echo "<th><span>Added</span></th><th><span>Action</span></th></tr></thead>";
    foreach ($saved->items as $item)
    {
        echo '<tr>';
        echo '<td>' . GetArtistsString($item->album->artists) . '</td>';
        echo '<td>' . $item->album->name . '</td>';
        echo '<td>' . $item->added_at . '</td>';
        echo '<td><a href="javascript:void" onclick="manage(\"'.$item->album->name.'\")">REMOVE</a></td>';
        echo '</tr>';
    }
    echo "</table>";
    echo "</div><p>&nbsp;</p>";   
}
?>



