<?php include 'navbar.php' ?>
<?php
require("connectDB.php");      // include("connect-db.php");
require("drinkDB.php");

$list_of_feelings = getAllFeelings($_SESSION['curr_user']);
$feeling_to_update = null;      
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Add') 
  {
        addFeeling($_POST['Rating'], $_SESSION['curr_user']);
        $list_of_feelings = getAllFeelings($_SESSION['curr_user']);  
  }

  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Delete')
  {
      deleteFeeling($_POST['feeling_to_delete']);
      $list_of_feelings = getAllFeelings($_SESSION['curr_user']); 
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
        font-size: 10em; 
    }

</style>

<body>

 <!-- Menu Bar  -->
<!-- <div class="">
    <h1> 
        Log Feelings Page. 
    </h1>
</div> -->

<form name="modifyFeelings" action="logfeelings.php" method="post">
    <div class="row mb-3 mx-3" style="margin-top: 20px; padding: 10px">
    Feeling Rating:
    <input type="text" class="form-control" name="Rating" required 
          value="<?php if ($feeling_to_update!=null) echo $feeling_to_update['Rating'] ?>"
    />
    </div>
    
    <div>
    <input type="submit" value="Add" name="btnAction" class="btn btn-dark" style="font-size: 20px; margin-left: 20px; border-radius: 12px;;padding: 14px 30px;" 
           title="Insert a feeling into feeling table" />  
    </div>            
</form>

<!-- <h3>Drink Log Entries</h3> -->


<h3 style= "margin-left: 80px">List of Feelings</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="40%"><b>Current User, Date, and Time</b></th>
    <th width="40%"><b>Rating </b></th>        
    <th width="1%"><b></b></th>        

    <!-- <th><b>Update?</b></th> -->
  </tr>
  </thead>
<?php foreach ($list_of_feelings as $feelings_info): ?>
  <tr>
     <td><?php echo $feelings_info['FeelingID']; ?></td>   
     <td><?php echo $feelings_info['Rating']; ?></td>                    
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