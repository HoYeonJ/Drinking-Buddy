<?php
require("connectDB.php");      // include("connect-db.php");
require("drinkDB.php");

$list_of_drinks = getAllDrinks();
$drinkname_to_update = null;      
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Add') 
  {
        addDrink($_POST['drinkname'], $_POST['caloriesperfloz']);
        $list_of_drinks = getAllDrinks();  
  }

  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Delete')
  {
      deleteDrink($_POST['drink_to_delete']);
      $list_of_drinks = getAllDrinks(); 
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

<body>
<!-- <?php include('header.html') ?>  -->
<?php include 'navbar.php' ?>
<form name="modifyDrinks" action="inputForm.php" method="post">

    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Drink Name:
    <input type="text" class="form-control" name="drinkname" required 
          value="<?php if ($drinkname_to_update!=null) echo $drinkname_to_update['drinkname'] ?>"
    />
    </div>
    <div class="row mb-3 mx-3" style="margin-top: 10px; padding: 10px">
    Calories Per Fl. Oz. : 
    <input type="text" class="form-control" name="caloriesperfloz" required 
          value="<?php if ($drinkname_to_update!=null) echo $drinkname_to_update['caloriesperfloz'] ?>"
    />
    </div>
    <div>
    <input type="submit" value="Add" name="btnAction" class="btn btn-dark" style="font-size: 20px; margin-left: 20px; border-radius: 12px;;padding: 14px 30px;"
           title="Insert a drink into drink table" />  
    </div>            
</form>


<div class="container">
  <h1>Drinks</h1>  
<hr/>
<!-- <h3>Drink Log Entries</h3> -->


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

</div>    

<!-- <?php include('footer.html') ?> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>