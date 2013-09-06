<?php
    $rif = $_GET["rif"];
    $url = "http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=$rif";
    print getPage($url, $rif);
    
    function getPage($url, $rif){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html=curl_exec($ch);
        if($html==false){
            $m=curl_error(($ch));
            error_log($m);
            curl_close($ch);
            $j['error'] = $m;
            return json_encode($j);
        } else {
            curl_close($ch);
            
            if (strpos($html, 'rif:numeroRif="') == false) {
                $j['rif'] = $rif;
                $j['error'] = "El RIF $rif no est&aacute; registrado o no existe";
                return json_encode($j);
            }
            
            $j['error'] = 0;
            
            #Obtener RIF
            $npos = strpos($html, 'rif:numeroRif="') + 15;
            $j['rif'] = trim(substr($html, ($npos), (strpos($html, '"', ($npos)) - ($npos))));

            #Obtener Nombre
            $npos = strpos($html, '<rif:Nombre>') + 12;
            $j['nombre'] = utf8_decode(trim(substr($html, ($npos), (strpos($html, '<', ($npos)) - ($npos)))));

            #Obtener Agente de retención
            $npos = strpos($html, '<rif:AgenteRetencionIVA>') + 24;
            $j['retencion'] = trim(substr($html, ($npos), (strpos($html, '<', ($npos)) - ($npos))));

            #Obtener Contribuyente
            $npos = strpos($html, '<rif:ContribuyenteIVA>') + 22;
            $j['contribuyente'] = trim(substr($html, ($npos), (strpos($html, '<', ($npos)) - ($npos))));

            #Obtener Tasa
            $npos = strpos($html, '<rif:Tasa>') + 10;
            $j['tasa'] = trim(substr($html, ($npos), (strpos($html, '<', ($npos)) - ($npos))));
            
            return json_encode($j);
        }
    } 
/*[08:20:42.675] " p3ompj9ln7sjvsjb7bhjgo95a6<?xml version="1.0" encoding="ISO-8859-1"?>
<rif:Rif xmlns:rif="rif" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" rif:numeroRif="V161934379">
    <rif:Nombre>NAHILET CABRERA REYES</rif:Nombre>
    <rif:AgenteRetencionIVA>NO</rif:AgenteRetencionIVA>
    <rif:ContribuyenteIVA>SI</rif:ContribuyenteIVA>
    <rif:Tasa>100</rif:Tasa>
</rif:Rif>
"*/
?>


