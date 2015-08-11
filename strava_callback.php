<?php

//CONFIGURE THESE VARIABLED TO YOUR REGISTERED FITBIT APP//

$clientid = 'INSERT YOUR CLIENT ID';
$clientsecret = 'INSERT YOUR CLIENT SECRET';
$redirecturi = 'INSERT YOUR APP REDIRCT URI';

//END CONFIGURATION//

if(isset($_GET['code'])){
	$code = $_GET['code'];
} else {
	$code = "";
}
if(isset($_GET['access_token'])){
	$access_token = $_GET['access_token'];
} else {
	$access_token = "";
}
if(isset($_GET['refresh_token'])){
	$refresh_token = $_GET['refresh_token'];
} else {
	$refresh_token = "";
}
if(isset($_GET['page'])){
	$page = $_GET['page'];
} else {
	$page = "";
}

if ($code != "") {
        $url = 'https://www.strava.com/oauth/token';

        $data = array(
                'code' => $code,
                'client_id' => $clientid,
                'client_secret' => $clientsecret,
                );

        $request_url = $url . '?' . http_build_query($data);

        $options = array(
                'http' => array(
                        'method' => 'POST'
                ),
        );
        $context  = stream_context_create($options);
        $POSTresult = @file_get_contents($request_url, false, $context);
	   if($POSTresult === FALSE)
		{
			echo "Invalid Code";
		} else {
			echo $POSTresult;
		}

} else {
        $req = $_GET['req'];
        switch ($req) {
                case 'activities':
                        $reqURL = '/athlete/activities?per_page=200&page='.$page;
                        break;
                case 'activity':
                        $activity = $_GET['activity'];
                        $reqURL = '/activities/'.$activity.'?';
                        break;
        }
        $url = 'https://www.strava.com/api/v3'.$reqURL.'&access_token='.$access_token;
        //echo $url;
        $options = array(
                'http' => array(
                        'method' => 'GET'
                ),
        );
        $context  = stream_context_create($options);
        $GETresult = file_get_contents($url, false, $context);

        echo $GETresult;
}
?>
