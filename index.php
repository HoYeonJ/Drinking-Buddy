 
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

<?php
require("drinkDB.php");
require("connectDB.php"); 
$list_of_drinks = getAllDrinks();
// $list_of_drinks = getTotalCalories();
$drinkname_to_update = null;    
// Redirect URLs
$_HomePageURL = 'http://localhost/Database_2022/index.php'  
?>

<!-- Just showing here what user is currently logged in -->
<!-- current user is $_SESSION['curr_user'] -->
<?php 
    // When user logs out --> Use to test login feature as needed 
    if(isset($_SESSION['curr_user'])) {
        print("logged in"); 
        print_r($_SESSION); 
    }
        
?>

<style>
    h1{
        text-align: center; 
        font-size: 10em; 
    }

</style>

<body>
<?php include 'navbar.php' ?>


 <!-- Menu Bar  -->
<!-- <div class="controller">
    <h1> 
        Index in PHP
    </h1>
</div> -->



</body>


<h3>List of drinks</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="40%"><b>Drink Name</b></th>
    <th width="40%"><b>Calories/ Fl. Oz. </b></th>        
    <th width="1%"><b></b></th>        

    <!-- <th><b>Update?</b></th> -->
    <th><b>Delete?                          </b></th>
  </tr>
  </thead>
<?php foreach ($list_of_drinks as $drink_info): ?>
  <tr>
     <td><?php echo $drink_info['DrinkName']; ?></td>
     <td><?php echo $drink_info['CaloriesPerFlOz']; ?></td>        
     
     <td><form action="inputForm.php" method="post">
          <input type="submit" value="Delete" name="btnAction" class="btn btn-danger"
                title="Click to delete this drink" />
          <input type="hidden" name="drink_to_delete" 
                value="<?php echo $drink_info['DrinkName']; ?>"/>                 
      </form></td>
  </tr>
<?php endforeach; ?>
</table>
</div>   

</html>