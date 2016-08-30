<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 29/8/16
 * Time: 11:31 PM
 */
require_once ('fbconfig.php');
require_once __DIR__ . '/vendor/autoload.php';


$helper = $fb->getRedirectLoginHelper();
try{
    $accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e){
    // When Graph returns an error
    echo 'Graph returned an error : ' .$e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e){
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error : ' .$e->getMessage();
    exit;
}
if(isset($accessToken)){
    // User Logged In !!
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    /**When a user first logs into your app, the access token your app receives
     * will be a short-lived access token that lasts about 2 hours.
     * It's generally a good idea to exchange the short-lived access
     * token for a long-lived access token that lasts about 60 days.*/

    // OAuth 2.0 Client Handler
    $oAuth2Client = $fb->getOAuth2Client();
    if( !$accessToken->isLongLived()) {
        // Exchange a short-lived access token for a long lived one !!!
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken('{access-token}');
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo "Error for obtaining long-lived token : " .$e->getMessage();
        }
    }
    header('Location: http://localhost/Facebook_app/index.php');
}
else{
    if ($helper->getError()) {
        header('Location: http://localhost/Facebook_app/index.php');
    } else {
        header('HTTP/1.0 400 Bad Request');
//            echo 'Bad request';
    }
    exit;
}
if(isset($_REQUEST['error'])){
    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason']=='user_denied'){
        header('Location: http://localhost/Facebook_app/index.php');
    }
}


