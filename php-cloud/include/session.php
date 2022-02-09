<?php
session_start();

if(isset($_SESSION['token'])){
    header("Location: vmlist.php");
}

function session($credentials, $loginurl){

$headers = array("Authorization: Basic $credentials", 
"Accept: application/*+xml;version=36.0");

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);

curl_setopt($ch, CURLOPT_URL, "$loginurl");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);


$response = preg_replace('/HTTP(.*)GMT/s', "", $response);
$response = preg_replace('/Content-Type(.*)/s', "", $response);
$response = preg_replace('/\r\n/', ",", $response);

$array1 = array();
$array2 = explode(',', $response);

foreach($array2 as $item) {
    list($key, $value) = explode(':', $item);
    $array1[$key] = $value;  
}
$token = $array1['X-VMWARE-VCLOUD-ACCESS-TOKEN'];

$token_error = "not authorized";
if ($token){
 return $token;   
}
else{
return $token_error; 
}

};



















// if($token){


// else{
//     echo "Неверный логин или пароль";
// }

//var_dump(session($credentials, $loginurl));


//session_destroy();  

// if ($_POST['del'] == 'kill_session'){
//     session_destroy();  
// }
?>
