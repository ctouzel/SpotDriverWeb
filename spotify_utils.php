<?php


//
// UPDATE PLAYLIST 
//
function UpdatePlaylist($name, $playlist, $library)
{
    $trackids = array(); 
    try
    {
        $trackids = AddRandomTracksFromLibrary($trackids, $library, USER_CHRIS, 12);
        switch ($name) 
        {
            case "Heartland":
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_HEARTLAND, USER_CHRIS, 2);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_HEARTLAND, USER_CHRIS, 10);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_ALBUMS_HEARTLAND, USER_CHRIS, 10);

                // CHRISTMAS CHECK
                if ((date("F") == "December" && date("j") > 25) || (date("F") == "January" && date("j") == 1))
                {
                    $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_REELS, USER_CHRIS, 12);
                }   
                else if ((date("F") == "December" && date("j") < 26) && date("j") > 5)
                {
                    $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_HEARTLAND_CHRISTMAS, USER_CHRIS, 10);
                }                               
                else if ((date("F") == "November" && date("j") > 21) || (date("F") == "December" && date("j") < 26))
                {
                    $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_HEARTLAND_CHRISTMAS, USER_CHRIS, 5);
                }
                $bundle   = array(); 
                $bundle   = AddRandomTracksFromLibrary($bundle, LIBRARY_DESERTROCK, USER_CHRIS, 10);
                $bundle   = AddRandomTracksFromLibrary($bundle, LIBRARY_COUNTRYSOUL, USER_CHRIS, 10);
                $bundle   = AddRandomTracksFromLibrary($bundle, LIBRARY_FRANCOFOLK, USER_CHRIS, 10);
                $trackids = AddRandomTracksFromBundle($trackids, $bundle, 1);
                break;
            case "Christian":
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_CHRISTIAN, USER_CHRIS, 2);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_CHRISTIAN, USER_CHRIS, 10);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_ALBUMS_CHRISTIAN, USER_CHRIS, 5);
//                $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_DISCOVERWEEKLY, USER_SPOTIFY, 5);
//                $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_RELEASERADAR, USER_SPOTIFY, 3);

                // CHRISTMAS CHECK
                if (date("F") == "December" && date("j") > 25)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_REELS, USER_CHRIS, 12);
                } 
                else if ((date("F") == "December" && date("j") < 26) && date("j") > 5)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 10);
                }                               
                else if ((date("F") == "November" && date("j") > 21) || (date("F") == "December" && date("j") < 26))
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 5);
                }
                break;
            case "ChristianPlus":
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_CHRISTIAN, USER_CHRIS, 2);
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_HEARTLAND, USER_CHRIS, 2);
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_HEARTLAND, USER_CHRIS, 8);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_CHRISTIAN, USER_CHRIS, 8);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_HEARTLAND, USER_CHRIS, 8);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_ALBUMS_CHRISTIAN, USER_CHRIS, 5);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_ALBUMS_HEARTLAND, USER_CHRIS, 5);
//                $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_DISCOVERWEEKLY, USER_DISCOVER, 5);
//                $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_RELEASERADAR, USER_SPOTIFY, 3);

                // CHRISTMAS CHECK
                if (date("F") == "December" && date("j") > 25)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_REELS, USER_CHRIS, 12);
                }
                else if ((date("F") == "December" && date("j") < 26) && date("j") > 5)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 10);
                }                               
                else if ((date("F") == "November" && date("j") > 21) || (date("F") == "December" && date("j") < 26))
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 5);
                }
                break;
            case "Couple":
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_CHRISTIAN, USER_CHRIS, 1);
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_GREAT_HEARTLAND, USER_CHRIS, 1);
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_HEARTLAND, USER_CHRIS, 4);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_CHRISTIAN, USER_CHRIS, 8);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_HEARTLAND, USER_CHRIS, 4);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_NICOLE, USER_CHRIS, 10);
                $trackids = AddRandomTracksFromLibrary($trackids, CLASSICS_NICOLE, USER_CHRIS, 20);

                // CHRISTMAS CHECK
                if (date("F") == "December" && date("j") > 25)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_REELS, USER_CHRIS, 12);
                }
                else if ((date("F") == "December" && date("j") < 26) && date("j") > 5)
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 10);
                }                               
                else if ((date("F") == "November" && date("j") > 21) || (date("F") == "December" && date("j") < 26))
                {
                        $trackids = AddRandomTracksFromLibrary($trackids, LIBRARY_CHRISTMAS, USER_CHRIS, 5);
                }
                break;
            case "Phil":
                $trackids = AddLatestTracksFromLibrary($trackids, TOP_SONGS_PHIL, USER_PHIL, 8);
                break;
            case "Simon":
                $trackids = AddLatestTracksFromLibrary($trackids, TOP_SONGS_SIMON, USER_SIMON, 8);
                 break;
            case "Nicole":
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_NICOLE, USER_CHRIS, 8);
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_ALBUMS_NICOLE, USER_CHRIS, 5);
                break;
            case "WSOL - Latin Radio":
                $trackids = AddRandomTracksFromLibrary($trackids, TOP_SONGS_LATIN, USER_CHRIS, 12);
                break;  
        }		
        shuffle($trackids);
        $success = $GLOBALS['api']->replaceUserPlaylistTracks(USER_CHRIS, $playlist, $trackids);
        LogThis("The ".$name." playlist has been updated.");
    }
    catch (Exception $e)
    {
        ManageException($e, "Unable to update ".$name." playlist");
    }
}

//
// ADD RANDOM TRACKS FROM LIBRARY
//
function AddRandomTracksFromLibrary($trackids, $library, $user, $num)
{
    $tracks   = GetAllPlaylistTrackIds($library, $user);
    shuffle($tracks);	
    if ($num > 0)
    {
        $tracks   = array_slice($tracks, 0, $num);
    }
    foreach ($tracks as $item)
    {
        array_push($trackids, $item);
    }
    return $trackids;
}

//
// ADD LATEST TRACKS FROM LIBRARY
//
function AddLatestTracksFromLibrary($trackids, $library, $user, $num)
{
    $tracks   = GetAllPlaylistTrackIds($library, $user);
    $tracks   = array_reverse($tracks);
    if ($num > 0)
    {
        $tracks = array_slice($tracks, 0, $num);
    }
    foreach ($tracks as $item)
    {
        array_push($trackids, $item);
    }
    return $trackids;
}

//
// ADD RANDOM TRACKS FROM BUNDLE
//
function AddRandomTracksFromBundle($trackids, $bundle, $num)
{
    shuffle($bundle);	
    $bundleSample = array_slice($bundle, 0, $num);
    foreach ($bundleSample as $item)
    {
        array_push($trackids, $item);
    }
    return $trackids;
}

//
// GET ALL PLAYLIST TRACK IDS
//
function GetAllPlaylistTrackIds($library, $user)
{
	$offset    = 0;
	$playlist  = GetPlaylistTracksSegment($library, $user, $offset);
	$tracks    = array();
	foreach ($playlist->items as $item)
	{
            if (isset($item->track->id))
            {
                array_push($tracks, $item->track->id);
            }
	}
	$total     = $playlist->total;
	$offset    = $offset + 100;
	while($total > $offset)
	{
            $newtracks = GetPlaylistTracksSegment($library, $user, $offset);
            $offset    = $offset + 100;	
            foreach ($newtracks->items as $item)
            {
                    array_push($tracks, $item->track->id);
            }
	}
	return $tracks;
}

//
// GET PLAYLIST TRACKS SEGMENT
//
function GetPlaylistTracksSegment($library, $user, $offset)
{
    $options["offset"] = $offset;
    $playlist          = $GLOBALS['api']->getUserPlaylistTracks($user, $library, $options);
    return $playlist;
}

//
// UPDATE CLASSICS
//
function UpdateClassics($name, $user, $topsongs, $classics)
{
    $trackids = array();
    try
    {
        $classicsids = GetAllPlaylistTrackIds($classics, USER_CHRIS);
        $topids      = GetAllPlaylistTrackIds($topsongs, $user);
        foreach ($topids as $topid)
	{
            if (in_array($topid, $classicsids) == false) 
            {
                array_push($trackids, $topid);
            }
	}
        if (count($trackids) > 0)
        {
            $GLOBALS['api']->addUserPlaylistTracks(USER_CHRIS, $classics, $trackids);
        }
        LogThis("The ".$name." classics have been updated.");
    }
    catch (Exception $e)
    {
        ManageException($e, "Unable to update ".$name." classics");
    }
}

?>



