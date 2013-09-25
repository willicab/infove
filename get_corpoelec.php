<?php

    $nic = $_GET["nic"];
    $url = "http://cobrosweb.cadafe.com.ve/enlinea/consultadeuda.aspx?nic=$nic";
    //$url = "http://willicab.gnu.org.ve/proxy/get_corpoelec.php";

    print getPage($url);
    
    function getPage($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch,CURLOPT_REFERER,'http://www.google.ch/');
        curl_setopt($ch,CURLOPT_TIMEOUT,10);
        $html=curl_exec($ch);
        if($html==false){
            $m=curl_error(($ch));
            error_log($m);
            curl_close($ch);
            $j['error'] = $m;
            return json_encode($j);
        } else {
            curl_close($ch);
            
            #Obtener NIC
            $npos = strpos($html, 'TextBox1') + 29;
            $j['nic'] = trim(substr($html, ($npos), (strpos($html, '"', ($npos)) - ($npos))));

            #Obtener USUARIO
            $npos = strpos($html, 'TextBox2') + 29;
            $j['usuario'] = trim(substr($html, ($npos), (strpos($html, '"', ($npos)) - ($npos))));

            #Obtener PAGO PENDIENTE
            $npos = strpos($html, 'TextBox7') + 29;
            $j['pendiente'] = trim(substr($html, ($npos), (strpos($html, '"', ($npos)) - ($npos))));

            #Obtener PAGO VENCIDO
            $npos = strpos($html, 'TextBox5') + 29;
            $j['vencido'] = trim(substr($html, ($npos), (strpos($html, '"', ($npos)) - ($npos))));

            # Obtener Error
            $j['error'] = ($j['usuario'] == 'y=' ? 'El Usuario no esta Registrado....' : 0);

            return json_encode($j);
        }
    } 
?>
