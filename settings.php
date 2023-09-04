<?php include 'navbar.php' ?>
<?php
require("connectDB.php");      // include("connect-db.php");
require("drinkDB.php");

$list_of_address = getAddress($_SESSION['curr_user']);
$list_of_phone = getPhone($_SESSION['curr_user']);
$list_of_users = getUserAndPass($_SESSION['curr_user']);
$Snum_to_update = null; 
$Sname_to_update = null; 
$city_to_update = null; 
$state_to_update = null; 
$zip_to_update = null; 
$phone_type_to_update = null;
$phone_num_to_update = null;
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Street Number') 
  {
        updateStreetNum($_POST['StreetNumber'], $_SESSION['curr_user']);
        $list_of_address = getAddress($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Street Name') 
  {
        updateStreetName($_POST['StreetName'], $_SESSION['curr_user']);
        $list_of_address = getAddress($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update City') 
  {
        updateCity($_POST['City'], $_SESSION['curr_user']);
        $list_of_address = getAddress($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update State') 
  {
        updateState($_POST['State'], $_SESSION['curr_user']);
        $list_of_address = getAddress($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Zip Code') 
  {
        updateZip($_POST['ZipCode'], $_SESSION['curr_user']);
        $list_of_address = getAddress($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Phone Type') 
  {
        updatePhoneType($_POST['PhoneType'], $_SESSION['curr_user']);
        $list_of_phone = getPhone($_SESSION['curr_user']);  
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Phone Number') 
  {
        updatePhoneNum($_POST['PhoneNumber'], $_SESSION['curr_user']);
        $list_of_phone = getPhone($_SESSION['curr_user']);  
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Andrea Jerausek">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<style>
    h1{
        text-align: center; 
        font-size: 7em; 
    }
    h3 {text-align: center;}

</style>

<body>
 <!-- Menu Bar  -->
<div class="">
    <h1> 
        Settings Page 
    </h1>
</div>

<br>

<h3>Address</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="20%"><b>Number</b></th>
    <th width="20%"><b>Street Name</b></th>     
    <th width="20%"><b>City</b></th>     
    <th width="20%"><b>State</b></th>     
    <th width="19%"><b>Zip Code</b></th>        
    <th width="1%"><b></b></th>        

    <!-- <th><b>Update?</b></th> -->
  </tr>
  </thead>
<?php foreach ($list_of_address as $address_info): ?>
  <tr>
     <td><?php echo $address_info['StreetNumber']; ?></td>   
     <td><?php echo $address_info['StreetName']; ?></td>    
     <td><?php echo $address_info['City']; ?></td>    
     <td><?php echo $address_info['StateResidence']; ?></td>        
     <td><?php echo $address_info['ZipCode']; ?></td>                
      </form></td>
  </tr>
<?php endforeach; ?>
</table>
</div>   

<h3>Phone Information</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="50%"><b>Phone Type</b></th>
    <th width="49%"><b>Phone Number</b></th>           
    <th width="1%"><b></b></th>        

    <!-- <th><b>Update?</b></th> -->
  </tr>
  </thead>
<?php foreach ($list_of_phone as $phone_info): ?>
  <tr>
     <td><?php echo $phone_info['PhoneType']; ?></td>   
     <td><?php echo $phone_info['PhoneNumber']; ?></td>                 
      </form></td>
  </tr>
<?php endforeach; ?>
</table>
</div>   

<br>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change Street Number:
    <input type="text" class="form-control" name="StreetNumber" required 
          value="<?php if ($Snum_to_update!=null) echo $Snum_to_update['StreetNumber'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update Street Number" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change Street Name:
    <input type="text" class="form-control" name="StreetName" required 
          value="<?php if ($Sname_to_update!=null) echo $Sname_to_update['StreetName'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update Street Name" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change City:
    <input type="text" class="form-control" name="City" required 
          value="<?php if ($city_to_update!=null) echo $city_to_update['City'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update City" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change State:
    <input type="text" class="form-control" name="State" required 
          value="<?php if ($state_to_update!=null) echo $state_to_update['State'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update State" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change Zip Code:
    <input type="text" class="form-control" name="ZipCode" required 
          value="<?php if ($zip_to_update!=null) echo $zip_to_update['ZipCode'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update Zip Code" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change Phone Type:
    <input type="text" class="form-control" name="PhoneType" required 
          value="<?php if ($phone_type_to_update!=null) echo $phone_type_to_update['PhoneType'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update Phone Type" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>

<form name="modifySettings" action="settings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Change Phone Number:
    <input type="text" class="form-control" name="PhoneNumber" required 
          value="<?php if ($phone_num_to_update!=null) echo $phone_num_to_update['PhoneNumber'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Update Phone Number" name="btnAction" class="btn btn-dark" style="font-size: 15px; margin-left: 20px; border-radius: 10px;;padding: 10px 15px;"
           title="Does this even show up anywhere?" />  
    </div>            
</form>



</div>    

<!-- <?php include('footer.html') ?> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>


</html>