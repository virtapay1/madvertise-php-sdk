<? 
// MADVERTISE - TestSite for PHP
// IMPORTANT: this code has to run before any content is printed to the page - otherwise the cookies won't work!
require('madvertise-snippet.php');
$madvertise_params = array(
  'site_token'    => 'TestTokn',
  'banner_type'   => 'mma'
);
$ad = madvertise_request($madvertise_params);
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
  "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
  <head>
    <title>Madvertise-Test-Applikation: PHP</title>
  </head>
  <?php
   //here goes the actual ad - place it somewhere on your site
   echo $ad
  ?>
  
  <h1>MADVERTISE - TestSite for PHP</h1>
  <h2>Integration is easy as pie!</h2>
  <p>
    <b>Look at this site with a mobile Browser to see the ad!</b>
  </p>
</html>