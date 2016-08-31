<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 29/8/16
 * Time: 10:26 PM
 */

    
    require_once __DIR__ . '/vendor/autoload.php';
    /*Facebook\Facebook is a service class provides an easy interface for working with all the components of the SDK.
    It passes an array of configuration options to the constructor.*/
    $fb = new Facebook\Facebook([
        'app_id' => '{AppID}',
        'app_secret' => '{AppSecret}',
        'default_graph_version' => 'v2.5',
    ]);
$app_id = 'AppId';
$app_secret = 'AppSecret';
$fb_login_url = 'http://localhost/Facebook_app/index.php';
session_start();
?>
