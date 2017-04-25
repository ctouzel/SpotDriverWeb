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
echo "<li class=\"home\"><a class=\"active\" href=\"home.php\">Home</a></li>".PHP_EOL;
echo "<li class=\"manage\"><a href=\"manage.php\">Manage</a></li>".PHP_EOL;
echo "<li class=\"playlists\"><a href=\"playlists.php\">Playlists</a></li>".PHP_EOL;
echo "<li class=\"reports\"><a href=\"reports.php\">Reports</a></li>".PHP_EOL;
echo "<li class=\"beta\"><a href=\"beta.php\">Beta</a></li>".PHP_EOL;
echo "</ul></div></header>".PHP_EOL;


// SPOTIFY OBJECTS
$session        = new Session(SPOTIFY_KEY,SPOTIFY_AUTH,LOGIN_RETURN);
$GLOBALS['api'] = new SpotifyWebAPI();
$refreshToken   = ReadFromFile(FILE_TOKEN);
$session->refreshAccessToken($refreshToken);
$GLOBALS['api']->setAccessToken($session->getAccessToken());

echo '<div class="wrapper2"><div class="wrapper2">'.PHP_EOL;
echo '<div class="title"><h1>SpotDriver Web</h1></div>'.PHP_EOL;
echo '<div class="masonry">'.PHP_EOL;

// ITEM 1
echo '<div class="item">'.PHP_EOL;
GetNewReleases();
echo '</div>'.PHP_EOL;

// ITEM 3
echo '<div class="item">'.PHP_EOL;
echo '<br/><p>SpotDriver Web '.VERSION.' written by Christian Touzel</p>';
echo '</div>'.PHP_EOL;

// ITEM 13
echo '<div class="item"><h1>Twang Nation</h1>'.PHP_EOL;
echo GetHeadlinesFromRSS("http://www.twangnation.com/feed/ ", 5, -1);
echo '</div>'.PHP_EOL;

// ITEM 13
echo '<div class="item"><h1>Spotify Dev</h1>'.PHP_EOL;
echo GetHeadlinesFromRSS("https://developer.spotify.com/feed/  ", 3, -1);
echo '</div>'.PHP_EOL;

// ITEM 4
echo '<div class="item">'.PHP_EOL;
GetTopArtistPic();
echo '</div>'.PHP_EOL;

// ITEM 6
echo '<div class="item"><h1>Uproxx News</h1>'.PHP_EOL;
echo GetHeadlinesFromRSS("http://www.uproxx.com/music/feed/", 8, -1);
echo '</div>'.PHP_EOL;

// ITEM 7
echo '<div class="item">'.PHP_EOL;
GetLogs();
echo '</div>'.PHP_EOL;

// ITEM 8
echo '<div class="item">'.PHP_EOL;
GetTopArtistPic();
echo '</div>'.PHP_EOL;

// ITEM 9
echo '<div class="item"><h1>Steven Hyden</h1>'.PHP_EOL;
echo GetHeadlinesFromRSS("http://uproxx.com/author/steven-hyden/feed/", 3, -1);
echo '</div>'.PHP_EOL;

// ITEM 10
echo '<div class="item">'.PHP_EOL;
GetSavedAlbums();
echo '</div>'.PHP_EOL;

// ITEM 11
echo '<div class="item"><h1>Stereogum</h1>'.PHP_EOL;
echo GetHeadlinesFromRSS("http://www.stereogum.com/feed/ ", 8, -1);
echo '</div>'.PHP_EOL;


echo '</div></div></div>'.PHP_EOL;

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
//
//
function GetNewReleases()
{
    $options["country"] = "CA";
    $saved = $GLOBALS['api']->getNewReleases($options);

    echo "<h1>New Releases</h1>";
    echo "<p>&nbsp;</p>";
    foreach ($saved->albums->items as $item)
    {
        echo '<p><i>';
        echo $item->name.'</i>, ';
        echo GetArtistsString($item->artists);
        echo '</p>';
    }     
}

//
// GET LOGS
//
function GetLogs()
{
    $logcontent = file(FILE_LOG, FILE_IGNORE_NEW_LINES);

    echo "<h1>Logs</h1>";
    echo "<div class=\"preformatted\">";
    $i = 0;
    foreach($logcontent as $line)
    {
        if ($i < 10)
        {
            if (substr($line, 0, 1) != ' ')
            {
                echo "<p><b>".$line."</b></p>";
            }
            else
            {
                if (strlen($line) > 60)
                {
                    $line = substr($line, 0, 60).'...';
                }
                echo "<p>".$line."</p>";
            }
            $i = $i + 1;
        }
    }
    echo "</div>";
}

//
// GET SAVED ALBUMS
//
function GetSavedAlbums()
{
    $saved = $GLOBALS['api']->getMySavedAlbums();
    $total = count($saved->items);
    $item  = $saved->items[rand(0,$total-1)];
    
    echo "<h1>".$item->album->name."</h1>";
    echo "<table cellspacing=\"0\" cellpadding=\"0\">";
    echo '<tr>';
    echo '<td><img src="'.$item->album->images[0]->url. '"</td>';
    echo '</tr>';

    echo "</table>";
}

//
// GET TOP ARTIST PIC
//
function GetTopArtistPic()
{
    try
    {
        $options["time_range"] = "medium_term";
        $options["limit"] = 50;
        $tops = $GLOBALS['api']->getMyTop("artists", $options);
        $item = $tops->items[rand(0,50)];
        echo "<h1>". $item->name ."</h1>";
        echo "<table cellspacing=\"0\" cellpadding=\"0\">";
        echo '<tr>';
        echo '<td><img style="display: block;margin: 0 auto;" src="'.$item->images[0]->url. '"</td>';
        echo '</tr>';
        echo "</table>";
    } 
    catch (Exception $e)
    {
        ManageException($e, "Unable to get top artist pic in the home page.");
    }
}

?>



