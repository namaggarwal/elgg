 <?php


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php');
gatekeeper();
$myguid = (int) get_loggedin_user()->guid;

global $ename;
global $edate;
global $etime; 
global $eloc;
global $etext;
global $ck;

if(isset($_POST['ename'])){ 
    $_SESSION['ename']=$_POST['ename'];
    $ename=$_POST['ename'];
}
if(isset($_POST['esdate'])){ 
    $_SESSION['esdate']=$_POST['esdate'];
    $esdate=$_POST['esdate'];
}
if(isset($_POST['eedate'])) {
    $_SESSION['eedate']=$_POST['eedate'];
    $eedate=$_POST['eedate'];
}
if(isset($_POST['estime'])) {
    $_SESSION['estime']=$_POST['estime'];
    $estime=$_POST['estime'];
}

if(isset($_POST['eetime'])) {
    $_SESSION['eetime']=$_POST['eetime'];
    $eetime=$_POST['eetime'];
}
if(isset($_POST['eloc'])) {
    $_SESSION['eloc']=$_POST['eloc'];
    $eloc=$_POST['eloc'];
}
if(isset($_POST['etext'])) {
    $_SESSION['etext']=$_POST['etext'];
    $text=$_POST['etext'];
}
if(isset($_POST['ck'])){
     $_SESSION['ck']=$_POST['ck'];
     $ck=$_POST['ck'];
}else{
    if(isset($_POST['ename'])){
   $gevents = new ElggObject();   

// Tell the system it's a message
    $gevents->subtype = "googleevents";
    
// Set its owner to the current user

    $gevents->owner_guid = $myguid;
    $gevents->container_guid = $myguid;
    
    $gevents->access_id = ACCESS_PRIVATE;
    
// Set its description appropriately
    $gevents->ename = $ename;
    $gevents->eedate = $eedate;
    $gevents->esdate = $esdate;
    $gevents->estime = $estime;
    $gevents->eetime = $eetime;
    $gevents->eloc = $eloc;
    $gevents->etext = $etext;
    $gevents->save();
    }
}

if(isset($_POST['ck']) || isset($_SESSION['ck'])){ 

    unset($_SESSION['token']);
    include_once('google/src/Google_Client.php');
    include_once('google/src/contrib/Google_CalendarService.php');

    $client = new Google_Client();
    $client->setApplicationName("Elgg");
    $client->setClientId('697820665951-slv7kgch9hsmk3i8jv93rq4l2spbn122.apps.googleusercontent.com');
    $client->setClientSecret('EWAM83ooA_jBCTt0aqwPesrL');
    $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'].'/elgg/mod/google_integration/events/');

    $cal = new Google_CalendarService($client);

        if (isset($_GET['logout'])) {
          unset($_SESSION['token']);
        }

        if (isset($_GET['code'])) {
            
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
           // header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
            unset($_SESSION['token']);
        }
       


      if ($client->getAccessToken()) {
        $event = new Google_Event();
        $event->setSummary($_SESSION['ename']);
        $event->setLocation($_SESSION['eloc']);

        $start = new Google_EventDateTime();
        $start->setDateTime($_SESSION['esdate'].'T'.$_SESSION['estime'].':00.000+08:00');
        $event->setStart($start);
        $end = new Google_EventDateTime();
        $end->setDateTime($_SESSION['eedate'].'T'.$_SESSION['eetime'].':00.000+08:00');
        $event->setEnd($end);
        $createdEvent = $cal->events->insert('primary', $event); //Returns array not an object
        
        // Save to ELGG
        $gevents = new ElggObject();   

    // Tell the system it's a message
        $gevents->subtype = "googleevents";
        
    // Set its owner to the current user

        $gevents->owner_guid = $myguid;
        $gevents->container_guid = $myguid;
        
        $gevents->access_id = ACCESS_PRIVATE;
        
    // Set its description appropriately
        $gevents->ename = $_SESSION['ename'];
        $gevents->eedate = $_SESSION['eedate'];
        $gevents->esdate = $_SESSION['esdate'];
        $gevents->estime = $_SESSION['estime'];
        $gevents->eetime = $_SESSION['eetime'];
        $gevents->eloc = $_SESSION['eloc'];
        $gevents->etext = $_SESSION['etext'];
        $gevents->save();
        unset($_SESSION['ename']);
        unset($_SESSION['esdate']);
        unset($_SESSION['eedate']);
        unset($_SESSION['eetime']);
        unset($_SESSION['estime']);
        unset($_SESSION['eloc']);
        unset($_SESSION['etext']);
        unset($_SESSION['ck']);
        unset($_SESSION['token']);
        forward($_SERVER['HTTP_REFERER'].'mod/google_integration/events/');
       }else {
             $authUrl = $client->createAuthUrl();
             forward($_SERVER['HTTP_REFERER'].'?url='.urlencode($authUrl));
            
        } 
    
    }else{
        unset($_SESSION['ename']);
        unset($_SESSION['esdate']);
        unset($_SESSION['eedate']);
        unset($_SESSION['eloc']);
        unset($_SESSION['etext']);
        unset($_SESSION['ck']);
        unset($_SESSION['eetime']);
        unset($_SESSION['estime']);
        unset($_SESSION['token']);
        forward($_SERVER['HTTP_REFERER']);

}


?>