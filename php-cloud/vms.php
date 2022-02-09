<?php
session_start();
require_once 'include/credentials.php';

$token = $_SESSION['token'];

function vm_list($token, $url){

$vm_list = array();
$header = array("Accept: application/*+json;version=36.0", "Authorization: Bearer $token");

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_URL, "$url/query?type=vm&format=idrecords&fields=name,container,status,containerName&filter=isVAppTemplate==false");

$response_vm = curl_exec($ch);

$vms = json_decode($response_vm, true);

$count = count($vms['record']);
for ($i = 0; $i<=$count-1; $i++) {
  $arr_vapp = explode(":", $vms['record'][$i]['container']);
  $vapp_id=$arr_vapp[3];

  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, 0);
  curl_setopt($ch, CURLOPT_URL, "$url/vApp/vapp-$vapp_id/leaseSettingsSection");
  $response_vapp = curl_exec($ch);
 

  $vapp = json_decode($response_vapp, true);

  $vmname = $vms['record'][$i]['name'];

  $arr_vmid = explode(":", $vms['record'][$i]['id']);
  $vm_id=$arr_vmid[3];
  $vm_list[$vmname]['id'] = $vm_id;


  if($vms['record'][$i]['status'] == "POWERED_ON" || $vms['record'][$i]['status'] == "PARTIALLY_POWERED_ON" ){
    $vm_list[$vmname]['status'] = "ON";
  }
  else if($vms['record'][$i]['status'] == "POWERED_OFF" || $vms['record'][$i]['status'] == "PARTIALLY_POWERED_OFF" ){
    $vm_list[$vmname]['status'] = "OFF";
  }
  
  else
  {
    $vm_list[$vmname]['status'] = "?";
  }

  $vm_list[$vmname]['containerName'] = $vms['record'][$i]['containerName'];

  $arr_date = explode("T", $vapp['deploymentLeaseExpiration']);
  $date_revers = explode("-", $arr_date[0]);
  $new_dt = array_reverse($date_revers);
  $newdate = implode('.', $new_dt);

  $vm_list[$vmname]['lease'] = $newdate;
  $vm_list[$vmname]['vappid'] = $vapp_id;

  //deploymentLeaseInSeconds 
  //storageLeaseInSeconds
  //deploymentLeaseExpiration 
  //storageLeaseExpiration
}

 curl_close($ch);

$json_data = json_encode($vm_list, JSON_UNESCAPED_UNICODE);

return $json_data;
};

vm_list($token, $url);

if(isset($_POST['vmlist'])){
  header("Content-Type: application/json; charset=UTF-8");  
  echo vm_list($token, $url);  
};

function poweroff($vmid, $token, $url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/*;version=36.0", "Authorization: Bearer $token"));  
  curl_setopt($ch, CURLOPT_POST, 1); 
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_URL, "$url/vApp/vm-$vmid/power/action/powerOff");
 
  $ou = curl_exec($ch);
  curl_close($ch);
 }
function poweron($vmid, $token, $url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/*;version=36.0", "Authorization: Bearer $token"));  
  curl_setopt($ch, CURLOPT_POST, 1); 
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, false);
  curl_setopt($ch, CURLOPT_URL, "$url/vApp/vm-$vmid/power/action/powerOn");
 
  $ou = curl_exec($ch);  
  curl_close($ch);  
}

if(isset($_POST['vm_id_off'])){  
  $vmid=$_POST['vm_id_off'];
  poweroff($vmid, $token, $url);  
};
if(isset($_POST['vm_id_on'])){  
  $vmid=$_POST['vm_id_on'];
  poweron($vmid, $token, $url);  
};

?>