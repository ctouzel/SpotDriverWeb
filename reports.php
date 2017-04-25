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
echo "</head>".PHP_EOL;
echo "<body><header>".PHP_EOL;
echo "<div class=\"nav\"><ul>".PHP_EOL;
echo "<li class=\"home\"><a href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a class=\"active\" href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header><p>&nbsp;</p>".PHP_EOL;

// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();
$refreshToken   = ReadFromFile(FILE_TOKEN);
$session->refreshAccessToken($refreshToken);
$GLOBALS['api']->setAccessToken($session->getAccessToken());

GetLogs();
GetTrackStats("Short Term", "short_term");
GetTrackStats("Medium Term", "medium_term");
GetTrackStats("Long Term", "long_term");
GetArtistsStats();
GetSavedAlbums();
GetFollowedArtists();


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
// GET TRACK STATS
//
function GetTrackStats($title, $term)
{
	$options["time_range"] = $term;
        $options["limit"] = 30;
	$tops = $GLOBALS['api']->getMyTop("tracks", $options);

	echo "<div id=\"wrapper\">";
	echo "<h1>Top Tracks - ".$title."</h1>";
	echo "<table id=\"keywords\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<thead><tr><th><span>Artists</span></th><th><span>Track</span></th></tr></thead>";
       
	foreach ($tops->items as $item)
	{
            echo '<tr>';
            echo '<td>' . GetArtistsString($item->artists) . '</td>';
            echo '<td>' . $item->name . '</td>';
            echo '</tr>';
	}
	echo "</table>";
 	echo "</div><p>&nbsp;</p>";
}

//
// GET ARTISTS STATS
//
function GetArtistsStats()
{
	$options["time_range"] = "short_term";
	$shortterm = $GLOBALS['api']->getMyTop("artists", $options);
        $options["time_range"] = "medium_term";
	$mediumterm = $GLOBALS['api']->getMyTop("artists", $options);
        $options["time_range"] = "long_term";
	$longterm = $GLOBALS['api']->getMyTop("artists", $options);

	echo "<div id=\"wrapper\">";
	echo "<h1>Top Artists</h1>";
	echo "<table id=\"keywords\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<thead><tr><th><span>Short Term</span></th>";
        echo "<th><span>Medium Term</span></th>";
        echo "<th><span>Long Term</span></th></tr></thead>";

        for ($x = 0; $x < 20; $x++) 
        {
            echo '<tr>';
            echo '<td>' . $shortterm->items[$x]->name . '</td>';
            echo '<td>' . $mediumterm->items[$x]->name . '</td>';
            echo '<td>' . $longterm->items[$x]->name . '</td>';
            echo '</tr>';
        } 
	echo "</table>";
 	echo "</div><p>&nbsp;</p>";
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
    echo "<th><span>Added</span></th></tr></thead>";
    foreach ($saved->items as $item)
    {
        echo '<tr>';
        echo '<td>' . GetArtistsString($item->album->artists) . '</td>';
        echo '<td>' . $item->album->name . '</td>';
        echo '<td>' . $item->added_at . '</td>';
        echo '</tr>';
    }
    echo "</table>";
    echo "</div><p>&nbsp;</p>";   
}

//
// GET FOLLOWED ARTISTS
//
function GetFollowedArtists()
{
        $followed = $GLOBALS['api']->getUserFollowedArtists();
    
 	echo "<div id=\"wrapper\">";
	echo "<h1>Followed Artists</h1>";
	echo "<table id=\"keywords\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<thead><tr><th><span>Artists</span></th></tr></thead>";
	foreach ($followed->artists->items as $item)
	{
            echo '<tr>';
            echo '<td>' . $item->name . '</td>';
            echo '</tr>';
	}
	echo "</table>";
 	echo "</div><p>&nbsp;</p>";   
}

//
// GET LOGS
//
function GetLogs()
{
	// GET ALL LINES OF EXISTING LOG
	$logcontent = file(FILE_LOG, FILE_IGNORE_NEW_LINES);
        $logcontent = str_ireplace("ERROR", "<span style='color: red;'>ERROR</span>", $logcontent);
	echo "<div id=\"wrapper\">";
	echo "<h1>Logs</h1>";
	echo "<div class=\"preformatted\">";
	foreach($logcontent as $line)
	{
            
            if (substr($line, 0, 1) != ' ')
            {
                    echo "<p><b>".$line."</b></p>";
            }
            else
            {
                    echo "<p>".$line."</p>";
            }

	}
 	echo "</div></div><p>&nbsp;</p>";
}

?>



