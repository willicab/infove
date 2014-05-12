<?php
$valor = array(
    'sarea'=>251,       //codigo de area sin el 0 ej: 212
    'stelefono'=> 4822545 //telefono sin codigo
);

//open connection
$ch = curl_init();
$url = 'http://www.cantv.com.ve/seccion.asp?pid=1&sid=450';
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($valor));
curl_setopt($ch, CURLOPT_VERBOSE, false);
curl_setopt($ch, CURLOPT_HEADER, CURLOPT_ENCODING);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($valor));
curl_setopt($ch, CURLOPT_REFERER,'http://www.cantv.com.ve/');
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux i686; rv:32.0) Gecko/20100101 Firefox/32.0');
//execute post
$resultado = curl_exec($ch);
curl_close($ch);
//parse response
$depurar = str_replace('</tr>', '\n', $resultado);
$elimina = strip_tags($depurar);
$datos = array_map('trim', explode('<br />', nl2br($elimina)));
$ini = (array_search("Saldo actual Bs.", $datos) + 1);
$data['telefono'] = $valor['sarea'] . '-' . $valor['stelefono'];
$data['saldo'] = $datos[$ini] . ' Bs.';
$data['facturacion'] = $datos[($ini + 7)];
$data['corte'] = $datos[($ini + 11)];
$data['vencimiento'] = $datos[($ini + 15)];
$data['vencido'] = $datos[($ini + 19)] . ' Bs.';
$data['monto'] = $datos[($ini + 23)] . ' Bs.';
echo json_encode($data);
?>
