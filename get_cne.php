<?php

    //$url = "http://www.cne.gob.ve/web/registro_electoral/ce.php?nacionalidad=$nacionalidad&cedula=$cedula";
    $url = "http://willicab.gnu.org.ve/proxy/get_cne.php";
    $nacionalidad = $_GET["nacionalidad"];
    $cedula = $_GET["cedula"];
    $str= "nacionalidad=$nacionalidad&cedula=$cedula";

    print getPage($url, $str);
    
    function getPage($url, $str){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch,CURLOPT_REFERER,'http://www.google.ch/');
        curl_setopt($ch,CURLOPT_TIMEOUT,10);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $str);
        $html=curl_exec($ch);
        if($html==false){
            $m=curl_error(($ch));
            error_log($m);
            curl_close($ch);
            $j['error'] = $m;
            return json_encode($j);
        } else {
            curl_close($ch);
            return $html;
        }
    } 
?>
