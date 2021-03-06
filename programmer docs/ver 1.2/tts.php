<?php

$url = 'http://translate.google.com/translate_tts?ie=UTF-8&q='. urlencode($_GET['q']) .'&tl='. $_GET['lang'] .'&total=1&idx=0&textlen=1000&client=tw-ob';//&ttsspeed=1';

$file = tempnam_sfx(sys_get_temp_dir(), '.mp3');

$response = curl_get($url);

file_put_contents($file, $response);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
ob_clean();
flush();
readfile($file);
unlink($file);
exit;

function curl_get($url) {

        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url); // use Random to generate unique URL every connect
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; rv:17.0) Gecko/20100101 Firefox/17.0');
        //curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        //curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow 302 header
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); //Don't use cache version, "Cache-Control: no-cache"
        //curl_setopt($ch, CURLOPT_VERBOSE, 1); //for get header
        //curl_setopt($ch, CURLOPT_HEADER, 1); //for get header
        // grab URL and pass it to the browser
        $response = curl_exec($ch);

        // Then, after your curl_exec call:
        //$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        //$header = substr($response, 0, $header_size);
        //$body = substr($response, $header_size);

        //Log::info($header);

        // close cURL resource, and free up system resources
        curl_close($ch);

        //return (string) $body;
        return $response;
}

function tempnam_sfx($path, $suffix) 
   { 
      do 
      { 
         $file = $path."/".mt_rand().$suffix; 
         $fp = @fopen($file, 'x'); 
      } 
      while(!$fp); 

      fclose($fp); 
      return $file; 
   }


?>