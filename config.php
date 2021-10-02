<?php

//start session on web page
// session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('101081617362-g0bokiokv6qgih5irj3pt50is5d67ojs.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('VE0FGszxwKKHqhEYjmK5A6ui');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/folder1/myfolder/g-callback.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?>  