<?php

require_once('twitteroauth/twitteroauth.php');

function twitter_get_tweets($twitteruser){

    $options = get_option( 'theme_options' );
    $consumer_key = $options['twitter_consumer_key'];
    $consumer_secret = $options['twitter_consumer_secret'];
    $access_token = $options['twitter_access_token'];
    $access_tokensecret = $options['twitter_access_tokensecret'];

    $cache = get_cache();

    if(is_array($cache)&&array_key_exists($twitteruser, $cache)){
        echo json_encode($cache[$twitteruser]);
        return;
    }

    if(empty($consumer_key)||empty($consumer_secret)||empty($access_token)||empty($access_tokensecret)){
        echo 'Twitter is not configured.';
        return;
    }

    $connection = getConnectionWithaccess_token($consumer_key, $consumer_secret, $access_token, $access_tokensecret);
    $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser);

    if(!is_array($cache))
        $cache = array();
    $cache[$twitteruser] = $tweets;
    set_cache($cache,60);

    echo json_encode($tweets);
}

function getConnectionWithaccess_token($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
    $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
    return $connection;
}

function linkify($status_text){
  $status_text = preg_replace(
    '/(https?:\/\/\S+)/',
    '<a href="\1">\1</a>',
    $status_text
  );
  $status_text = preg_replace(
    '/(^|\s)@(\w+)/',
    '\1@<a href="http://twitter.com/\2">\2</a>',
    $status_text
  );
  $status_text = preg_replace(
    '/(^|\s)#(\w+)/',
    '\1#<a href="http://search.twitter.com/search?q=%23\2">\2</a>',
    $status_text
  );
  return $status_text;
}

function get_cache(){
    if(file_exists('twitter.txt')){
        $file = file_get_contents('twitter.txt');
        if($file!==false&&$file!==''){
            $data = unserialize($file);
            $time = time();
            if($data['time']+$data['expire']>$time){
                return $data['data'];}
            file_put_contents('twitter.txt', '');
        }
    }
}

function set_cache($arr,$expire){
    if(file_exists('twitter.txt')){
        $file = file_get_contents('twitter.txt');
        $data = unserialize($file);
    }else
        $data = array();
    $data['time'] = time();
    $data['expire'] = $expire;
    $data['data'] = $arr;
    $file = serialize($data);
    file_put_contents('twitter.txt', $file);
}

add_action('wp_ajax_get_tweets','tt_get_tweets');
add_action('wp_ajax_nopriv_get_tweets','tt_get_tweets');
function tt_get_tweets(){
if(isset($_GET['user']))
    twitter_get_tweets($_POST['user']);
die();
}