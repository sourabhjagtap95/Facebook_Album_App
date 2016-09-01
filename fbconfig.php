<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 29/8/16
 * Time: 10:26 PM
 */

    if (!session_id()) {
    session_start();
}
    require_once __DIR__ . '/vendor/autoload.php';
    /*Facebook\Facebook is a service class provides an easy interface for working with all the components of the SDK.
    It passes an array of configuration options to the constructor.*/
    $fb = new Facebook\Facebook([
        'app_id' => '',         //Your App ID
        'app_secret' => '',     //Your App Secret
        'default_graph_version' => 'v2.5',
    ]);
$app_id = '';   //Type here also
$app_secret = '';
// session_start();
?>
