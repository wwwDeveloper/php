<?php
session_start();
if(!$_SESSION['token']){
    header("Location: /");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/vmlist.css" rel="stylesheet" type="text/css">
    <title>VMList</title>
</head>
<body>
    
   <div>
   
<div class="container">
   
  <div id="loader"></div>
  
 <div class="btn-logout">
    <button class="btn-item" onclick="logout();">LogOut</button>
    </div>   

<table class="table">
    
    <tr class="table-header">
     <th class="col-vmname col-text-main">VM name</th>
     <th class="col-vappname">vApp name</th>
     <th class="col-date">expire date</th>
     <th class="col-select">change lease</th>
    
     <th class="col-state">state</th>
     <th class="col-button"></th>   

    </tr>
   
</table>

 </div><!-- container -->
 </div> <!-- alldisplay -->

 <script src="js/main.js"></script>

</script>
</body>
</html>

