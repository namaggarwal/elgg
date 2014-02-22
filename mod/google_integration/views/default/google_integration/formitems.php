<?php


gatekeeper();
// disable warnings
/*if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 
*/

$sClientId = '697820665951-1ljjtmecmnv5losh3d2n01pktpacglfm.apps.googleusercontent.com';
$sClientSecret = '_ytVlByJ-ZeMT34B5kjEdMua';
$sCallback = 'http://'.$_SERVER['HTTP_HOST'].'/elgg/mod/google_integration/index.php'; // callback url, don't forget to change it to your!
$iMaxResults = 1000; // max results
$sStep = 'auth'; // current step

// include GmailOath library  https://code.google.com/p/rspsms/source/browse/trunk/system/plugins/GmailContacts/GmailOath.php?r=11
include_once('classes/GmailOath.php');

///session_start();

// prepare new instances of GmailOath  and GmailGetContacts
$oAuth = new GmailOath($sClientId, $sClientSecret, $argarray, false, $sCallback);
$oGetContacts = new GmailGetContacts();

if ($_GET && $_GET['oauth_token']) {
    global $aContacts;
    $sStep = 'fetch_contacts'; // fetch contacts step

    // decode request token and secret
    $sDecodedToken = $oAuth->rfc3986_decode($_GET['oauth_token']);

    $sDecodedTokenSecret = $oAuth->rfc3986_decode($_SESSION['oauth_token_secret']);

    // get 'oauth_verifier'
    $oAuthVerifier = $oAuth->rfc3986_decode($_GET['oauth_verifier']);

    // prepare access token, decode it, and obtain contact list
    $oAccessToken = $oGetContacts->get_access_token($oAuth, $sDecodedToken, $sDecodedTokenSecret, $oAuthVerifier, false, true, true);
    $sAccessToken = $oAuth->rfc3986_decode($oAccessToken['oauth_token']);
    $sAccessTokenSecret = $oAuth->rfc3986_decode($oAccessToken['oauth_token_secret']);
    $aContacts = $oGetContacts->GetContacts($oAuth, $sAccessToken, $sAccessTokenSecret, false, true, $iMaxResults);
    // turn array with contacts into html string
    $sContacts = $sContactName = '';
} else {
    // prepare access token and set it into session
    $oRequestToken = $oGetContacts->get_request_token($oAuth, false, true, true);
    $_SESSION['oauth_token'] = $oRequestToken['oauth_token'];
    $_SESSION['oauth_token_secret'] = $oRequestToken['oauth_token_secret'];
}

?>

    <link rel="stylesheet" type="text/css" href="jquery-checkbox-search.css" />
    <SCRIPT LANGUAGE="JavaScript" SRC="jquery-checkbox-search-min.js"></SCRIPT>
<div class="contentWrapper notitle">
<p><label>
	<?php echo elgg_echo('Find friends from Google !!!'); ?>
</label></p>

<?php if ($sStep == 'auth' ):?>
   
<div id="g_img" align="center">
<a href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=
<?php echo $oAuth->rfc3986_decode($oRequestToken['oauth_token']) ?>"><img src = "././././images/google.jpg" height=70% width=40%/></a>
</div>

<?php elseif ($sStep == 'fetch_contacts'): 	
if (is_array($aContacts) && !empty($aContacts)) {
	?><form id="google" action="/action/google_integration/invite">
    <div id="brandsSuggestContainer">
            <input onKeyUp="matchBrands(this.value);" ></input>
            <div id="brandSuggestion"></div>
    </div>  

    <?php
     echo elgg_view('input/submit', array('value' => elgg_echo('Send Friend Requests'))); 
    foreach($aContacts as $k => $aInfo) {
    	$sContactName = end($aInfo['title']);
        $aLast = end($aContacts[$k]);	
        foreach($aLast as $aEmail) {
        	if (empty($sContactName)) {
        		$sContactName=$aEmail['address'];	
        	}
           echo '<div class="checkbox_container"><input type="checkbox" name="gids[]" value="'.$aEmail['address'].'"> <span>' . $sContactName.'</span></div>';
        }    
    }
   
    ?></form>
</div>
<?php } endif 


?>