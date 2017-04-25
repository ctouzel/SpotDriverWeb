<?php

//
// INCLUDES
//
include("constants_spotdriver.php");
include("Session.php");

//
// SPOTDRIVER WEB START 
//

$session      = new Session(SPOTIFY_KEY, SPOTIFY_AUTH, LOGIN_RETURN);
$scopes       = array('playlist-read-private','user-read-private','user-library-read','user-top-read','playlist-modify-public','user-follow-read');

header('Location: ' . $session->getAuthorizeUrl(array('scope' => $scopes)));
die();

?>

