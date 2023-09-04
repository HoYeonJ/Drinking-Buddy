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
        font-size: 3em; 
    }
</style>

<?php
require("drinkDB.php");
require("connectDB.php"); 
session_start();    

// Redirect URLs
$_HomePageURL = 'http://localhost/Database_2022/index.php'  
?>

<!-- Register New Account vs Login Button Reaction   -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // if the input button with 'name' == register and value == 'Sign Up' selected
    if(!empty($_POST['register']) && $_POST['register'] =='Register' && !isset($_SESSION['registrationPage']))
    {
        // Set the signupPage variable to display HTML for Registration instead of login page
        $_SESSION['registrationPage'] = 1;
        // Unset loginPage if it is set  
        if(isset($_SESSION['loginPage'])) {
            unset($_SESSION['loginPage']); 
        }
    } else if(!empty($_POST['login']) && $_POST['login'] =='Log In' && !isset($_SESSION['loginPage'])) 
    {
        $_SESSION['loginPage'] = 1;
        // Unset loginPage if it is set  
        if(isset($_SESSION['registrationPage'])) {
            unset($_SESSION['registrationPage']); 
        }
    } else if (!empty($_POST['register']) && $_POST['register'] =='Register' && isset($_SESSION['registrationPage'])) 
    {
        if(strlen($_POST['Email']) <= 0 || strlen($_POST['Password']) <= 0 || strlen($_POST['Username']) <= 0 || 
        strlen($_POST['StreetNumber']) <= 0  || strlen($_POST['StreetName']) <= 0 || strlen($_POST['City']) <= 0 ||
        strlen($_POST['StateResidence']) <= 0 || strlen($_POST['Zipcode']) <= 0 || strlen($_POST['PhoneType']) <= 0 || 
        strlen($_POST['PhoneNumber']) <= 0 )
        {   
            print( "enter valid values for all inputs. ");

        } else {
        register($_POST['Email'], $_POST['Username'], $_POST['Password'], $_POST['StreetNumber'], $_POST['StreetName'], 
        $_POST['City'], $_POST['StateResidence'], $_POST['Zipcode'], $_POST['PhoneType'], $_POST['PhoneNumber']);  
        print ("user registered!"); 
        }

    } else if (!empty($_POST['login']) && $_POST['login'] =='Log In' && isset($_SESSION['loginPage'])) 
    {
        // Check if user is registered or not with that email
        if(!is_null($_POST['Email']) && !is_null($_POST['Password'])) {
            $userEmail = findUser($_POST['Email'], $_POST['Password']); 
            if (count($userEmail) > 0) {
                // start session with this user !
                print("set current user"); 
                $_SESSION['curr_user'] = $userEmail; 
                $_SESSION['logged_in'] = 1; 

                // Redirect to homepage
                header('Location:'.$_HomePageURL); 
                print("new page"); 
            } 
        } else {
            print("please enter an email and a password!"); 
        }

    // When user logs out --> Use to test login feature as needed 
    // if(isset($_SESSION['curr_user'])) {
    //     print("logged in"); 
    //     print_r($_SESSION); 
    //     unset($_SESSION['curr_user']); 
    //     unset($_SESSION['logged_in']); 

    // }
    // print("unset"); 
    // print_r($_SESSION); 

    // Use to test what the return email is 
    // $userEmail = findUser($_POST['Email']); 
    // foreach ($userEmail as $eachUser): 
    //     echo $eachUser['Email']; 
    // endforeach; 

    }
}
?>


<h1>
Hi welcome to drinking buddy! Log in or register a new account to get started. 
</h1>

</br> 
</br>

<form name="register" action="loginpage.php" method="post">  

<?php
if(isset($_SESSION['registrationPage'])) {
?>
<!-- Registration page html. -->
    <div class="d-grid gap-2 col-3 mx-auto">
    Email: 
    <input type="text" class="form-control" name="Email" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    Username:
    <input type="text" class="form-control" name="Username" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    Password: 
    <input type="text" class="form-control" name="Password" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    StreetNumber: 
    <input type="text" class="form-control" name="StreetNumber" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    StreetName:
    <input type="text" class="form-control" name="StreetName" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    City: 
    <input type="text" class="form-control" name="City" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    StateResidence: 
    <input type="text" class="form-control" name="StateResidence" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    ZipCode:
    <input type="text" class="form-control" name="Zipcode" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    PhoneType: 
    <input type="text" class="form-control" name="PhoneType" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    PhoneNumber: 
    <input type="text" class="form-control" name="PhoneNumber" />
    </div>
<?php 
} else if (isset($_SESSION['loginPage'])) {
?>
<!-- Login Page HTML. -->
    <div class="d-grid gap-2 col-3 mx-auto">
    Email: 
    <input type="text" class="form-control" name="Email" />
    </div>
    <div class="d-grid gap-2 col-3 mx-auto">
    Password:
    <input type="text" class="form-control" name="Password" />
    </div>

<?php 
    }
?>

</br> 
    <div class='d-grid gap-2 col-2 mx-auto'>
    <button  value="Register" name="register" type="submit" class="btn btn-primary btn-lg">Register</button>
    
    <button value="Log In" name="login" type="submit" class="btn btn-secondary btn-lg">Log In</button>
    </div>
</form>


<!-- How to display certain HTML things based on php if statements  -->
<?php
// if(isset($_SESSION['curr_user'])) 
// {
 
?>
<!-- User logged in! -->
<?php
// } else {
?>

<!-- Not logged in! -->
<?php
// }
?>


</html>