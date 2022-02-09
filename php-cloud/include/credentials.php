<?php
session_start();

// base_64(user@tenant_name:password)

$loginurl = "https://vcd.company/api/sessions";
$url = "https://vcd.company/api";


function authorize($username, $password){
$tenat_name = "tenatName";

$credentials = base64_encode($username."@".$tenat_name.":".$password);

return $credentials;

};

?>