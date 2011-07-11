<?php
function madvertise_request($madvertise_params = array('site_token' => 'TestTokn')) {
    $protocol = 'http';
    if(!empty($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']))
      $ua = $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
    else
      $ua =  $_SERVER['HTTP_USER_AGENT'];
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
      $ip =  $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') $protocol = 'https';

    $debug = empty($madvervise_params['debug']) ? '0' : $madvervise_params['debug'];

    $params = array('ua=' . urlencode($ua),
                    'ip=' . urlencode($ip),
                    'url=' . urlencode("$protocol://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),
                    'debug=' . urlencode($debug),
                    'uu=' . urlencode($_COOKIE['madvertise']),
                    'banner_type=' . urlencode($madvervise_params['banner_type'])
                    );

    $post = implode('&', $params);
    $request = curl_init();
    $request_timeout = 1; // 1 second timeout
    curl_setopt($request, CURLOPT_URL, 'http://ad.madvertise.de/site/' . $madvertise_params['site_token']);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_HEADER, 1);
    curl_setopt($request, CURLOPT_TIMEOUT, $request_timeout);
    curl_setopt($request, CURLOPT_CONNECTTIMEOUT, $request_timeout);
    curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: Close'));
    curl_setopt($request, CURLOPT_POSTFIELDS, $post);
    $contents = curl_exec($request);
    preg_match("/<a.*\\/>/", $contents, $results);
    $result = $results[0];
    preg_match("/madvertise=(.*)\\s/", $contents, $token);
    curl_close($request);
    $newcookie = trim($token[1]);
    if(!empty($newcookie)) 
      setcookie('madvertise', $newcookie, time()+60*60*24*30*24); //2 years
    if ($contents === true || $contents === false) 
      $result = '';
    return $result;
  }
?>