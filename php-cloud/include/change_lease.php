<?php

include 'credentials.php';

$token = $_SESSION['token'];

if(isset($_POST['renew_lease'])){  
$arr_lease = explode(",", $_POST['renew_lease']);
$idvapp =  $arr_lease[0];   
$deplease =  $arr_lease[1]*86400;
xmlrequest($url, $idvapp, $deplease);
renew_lease($url, $token, $idvapp);   
}

function xmlrequest($url, $idvapp, $deplease){

$xmlreq = <<<XML
<?xml version="1.0" encoding="UTF-8"?><vcloud:LeaseSettingsSection
xmlns:ovf="http://schemas.dmtf.org/ovf/envelope/1"
xmlns:vcloud="http://www.vmware.com/vcloud/v1.5"
href="$url/vApp/vapp-$idvapp/leaseSettingsSection/"
ovf:required="false"
type="application/vnd.vmware.vcloud.leaseSettingsSection+xml">
<ovf:Info>Lease settings section</ovf:Info>
<vcloud:Link 
    href= "$url/vApp/vapp-$idvapp/leaseSettingsSection/"
    rel="edit"
    type="application/vnd.vmware.vcloud.leaseSettingsSection+xml"/>
<vcloud:DeploymentLeaseInSeconds>$deplease</vcloud:DeploymentLeaseInSeconds>
<vcloud:StorageLeaseInSeconds>2592000</vcloud:StorageLeaseInSeconds> 
</vcloud:LeaseSettingsSection>
XML;

$xml = simplexml_load_string($xmlreq);
$xml->asXML('../xml/renew_lease.xml');


};


function renew_lease($url, $token, $idvapp){

$request_file = '../xml/renew_lease.xml';
$fp = fopen($request_file, 'r'); 
  
$header = array("Accept: application/*+json;version=36.0", "Authorization: Bearer $token");
  
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
curl_setopt($ch, CURLOPT_PUT, true);   
curl_setopt($ch, CURLOPT_UPLOAD, true);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($request_file));
curl_setopt($ch, CURLOPT_INFILE, $fp);   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);    
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, "$url/vApp/vapp-$idvapp/leaseSettingsSection/");

  
$response_lease = curl_exec($ch);    
$resp_decode = json_decode($response_lease, true);
$arr_date = explode("T", $resp_decode['expiryTime']);
$date_revers = explode("-", $arr_date[0]);
$new_dt = array_reverse($date_revers);
$newdate = implode('.', $new_dt);
curl_close($ch);     
echo $newdate; 
  

};

?>