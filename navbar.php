<!DOCTYPE> 
<html> 
<?php
// require("drinkDB.php");
// require("connectDB.php"); 
session_start();    

// // Redirect URLs
$_LogInPage = 'http://localhost/Database_2022/loginpage.php'  
?>


<?php 
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    print("in post");
    if(!empty($_POST['logout']) && $_POST['logout'] =='Log Out') {
      print("logout"); 
      if(isset($_SESSION['curr_user'])) 
      {
        print('changepages');
        session_destroy(); 
        header('Location:'.$_LogInPage); 

      }
      print("after checking curr user setting"); 
    }
  }

?>

<nav class="lead navbar navbar-expand-lg navbar-light" style="background-color: #000; display:flex; padding: auto; margin: auto; align-items: center;">
  <a class="display-4 navbar-brand" href="index.php" style="font-size: 1.5em;
   color: #caf1de;
   font-weight: bold;
    font-size: 3rem;
  ">Drinking Buddy</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="lead collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php" style = "color:white">Home </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="inputForm.php" style = "color:white">Add Drink Type</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="calendar.php" style = "color:white"> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logentries.php" style = "color:white">Log Entry</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logfeelings.php" style = "color:white;">Log Feelings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php" style = "color:white;">Settings</a>
      </li>
      <style>
        .nav-item {
          font-family: arial;
          font-size: 25px;
          font-weight: bold;
        }

        .nav-item:hover{
          background-color: #8B4000;
          transition: all 0.5s ease; /*delay in color change when hover button  */
        } 
      </style>

      <li class="nav-item-logOut">
      <form name="signout" action="loginpage.php" method="post">  
        <button value="Log Out" name="logout" type="submit" class="btn btn-success btn-lg" style= "
          border: none;
          color: white;
          border-radius: 12px;
          padding: 10px 20px;
          text-align: center;
          position: absolute;
          right: 0;
          font-weight: bold;"
  font-size: 16px;>Log Out</button>

      </form>
      </li>
    </ul>
  </div>
</nav>
</html> 