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

// HEADER
echo "<!DOCTYPE html>".PHP_EOL;
echo "<html xmlns='http://www.w3.org/1999/xhtml'>".PHP_EOL;
echo "<head>".PHP_EOL;
echo "<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"UTF-8\" />".PHP_EOL;
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"spotdriver.css\">".PHP_EOL;
echo "<link rel=\"icon\" href=\"favicon.ico\">".PHP_EOL;
echo "<title>".TITLE."</title>".PHP_EOL;
echo "<script>".PHP_EOL;
echo "function showHint(p1) {".PHP_EOL;
echo "        var xmlhttp = new XMLHttpRequest();".PHP_EOL;
echo "        xmlhttp.onreadystatechange = function() {".PHP_EOL;
echo "            if (this.readyState == 4 && this.status == 200) {".PHP_EOL;
echo "                document.getElementById(\"txtHint\").innerHTML = this.responseText;".PHP_EOL;
echo "            }".PHP_EOL;
echo "        };".PHP_EOL;
echo "        xmlhttp.open(\"GET\", \"playlist.php?q=\"+p1+\"\" , true);".PHP_EOL;
echo "        xmlhttp.send();".PHP_EOL;
echo "}".PHP_EOL;
echo "</script>".PHP_EOL;
echo "</head>".PHP_EOL;
echo "<body><header>".PHP_EOL;
echo "<div class=\"nav\"><ul>".PHP_EOL;
echo "<li class=\"home\"><a href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a class=\"active\" href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header><p>&nbsp;</p>".PHP_EOL;

// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();
$refreshToken   = ReadFromFile(FILE_TOKEN);
$session->refreshAccessToken($refreshToken);
$GLOBALS['api']->setAccessToken($session->getAccessToken());

echo "<div id=\"wrapper\">";
echo "<h1>Update Playlists</h1>";
echo "<table>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='acadie' onclick='showHint(\"Acadie\")'>Acadie</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='baseball' onclick='showHint(\"Baseball\")'>Baseball</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='christian' onclick='showHint(\"Christian\")'>Christian</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='countrysoul' onclick='showHint(\"CountrySoul\")'>Country and Soul</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='heartland' onclick='showHint(\"Heartland\")'>Heartland</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='heartland2' onclick='showHint(\"Heartland2\")'>Heartland 2</a></td>";
echo "</tr>";
echo "<tr><td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='francofolk' onclick='showHint(\"Francofolk\")'>Franco and Folk</a></td></tr>";
echo "<tr>";
echo "<td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='nicole' onclick='showHint(\"Nicole\")'>Nicole</a></td>";
echo "</tr>";
echo "<tr><td><a href='javascript:void' style='font-size:2.2em;font-family:Amarante;' id='phil' onclick='showHint(\"Phil\")'>Phil</a></td></tr>";
echo "<tr><td>&nbsp;</td></tr>";
echo "</table>";
echo "<h1>Result</h1>";
echo "<p style='font-size:2.2em'><span id=\"txtHint\"></span></p>";

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



