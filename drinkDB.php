<?php

function addDrink($drinkname, $caloriesperfloz)
{
    global $db;
    $query = "INSERT INTO drinks VALUES (:drinkname, :caloriesperfloz)";  
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':drinkname', $drinkname);
        $statement->bindValue(':caloriesperfloz', $caloriesperfloz);
        $statement->execute();
        $statement->closeCursor();

    }
    catch (PDOException $e) 
    {
        if (str_contains($e->getMessage(), "Duplicate"))
            echo "Failed to add a drink. Two drinks with same name. <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

function getAllDrinks()
{
    global $db; 
    $query = "SELECT * FROM drinks";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function deleteDrink($drinkname)
{
    global $db; 
    $query = "DELETE FROM drinks WHERE drinkname=:drinkname"; 
    $statement = $db->prepare($query); 
    $statement->bindValue(':drinkname', $drinkname); 
    $statement->execute(); 
    $statement->closeCursor(); 
}

function getAllUsers()
{
    global $db; 
    $query = "SELECT * FROM user"; 
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

// Logs User in if username and password match 
function findUser($Email, $Password) 
{
    global $db; 
    $query = "SELECT Email FROM USER WHERE Email='$Email' AND Password='$Password'"; 
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();   
    $statement->closeCursor();
    return $result;
}

// For user credentials in index.php
function register($Email, $Username, $Password, $StreetNumber, $StreetName, $City, $StateResidence, $Zipcode, $PhoneType, $PhoneNumber)
{
    global $db;
    $query1 = "INSERT INTO user VALUES (:Email, :Username, :Password)";
    $query2 =  "INSERT INTO useraddress VALUES(:Email, :StreetNumber, :StreetName, :City, :StateResidence, :Zipcode)";
    $query3 = "INSERT INTO phone VALUES(:Email, :PhoneType, :PhoneNumber)";  
    try {
        $statement = $db->prepare($query1);
        $statement2 = $db->prepare($query2);
        $statement3 = $db->prepare($query3);
        $statement->bindValue(':Email', $Email);
        $statement->bindValue(':Username', $Username);
        $statement->bindValue(':Password', $Password);

        $statement2->bindValue(':Email', $Email);
        $statement2->bindValue(':StreetNumber', $StreetNumber);
        $statement2->bindValue(':StreetName', $StreetName);
        $statement2->bindValue(':City', $City);
        $statement2->bindValue(':StateResidence', $StateResidence);
        $statement2->bindValue(':Zipcode', $Zipcode);
        
        $statement3->bindValue(':Email', $Email);
        $statement3->bindValue(':PhoneType', $PhoneType);
        $statement3->bindValue(':PhoneNumber', $PhoneNumber);

        $statement->execute();
        $statement->closeCursor();

        $statement2->execute();
        $statement2->closeCursor();

        $statement3->execute();
        $statement3->closeCursor();

    }
    catch (PDOException $e) 
    {
        if (str_contains($e->getMessage(), "Duplicate"))
		   echo "User with this email is already registered. Login or register with a new email. <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

function addFeeling($feelingValue, $currUser2)
{
    global $db;
    $currUser = array_values($currUser2)[0][0];
    $FeelingID = $currUser; //$_SESSION['curr_user']; // THIS IS HARD CODED, NEEDS TO BE FIXED AT SOME POINT !!!!!
    $dateVar = date('Y-m-d H:i:s');
    $FeelingID .= $dateVar;
    $currUserEmail = $currUser;
    $query = "INSERT INTO userfeelings VALUES (:FeelingID, :feelingValue)";  
    $query2 = "INSERT INTO recordfeelings VALUES (:FeelingID, :currUserEmail)"; // THIS IS ALSO HARDCODED AND NEEDS TO BE FIXED !!
    try {
        $statement = $db->prepare($query);
        $statement2 = $db->prepare($query2);

        $statement->bindValue(':feelingValue', $feelingValue);
        $statement->bindValue(':FeelingID', $FeelingID);
        $statement2->bindValue(':FeelingID', $FeelingID);
        $statement2->bindValue('currUserEmail', $currUserEmail);

        $statement->execute();
        $statement->closeCursor();

        $statement2->execute();
        $statement2->closeCursor();

    }
    catch (PDOException $e) 
    {
        if (str_contains($e->getMessage(), "Duplicate"))
		   echo "Failed to add a feeling. <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
} 

function addEntry($drinkname, $amount, $currUser2)
{
    global $db;
    $currUser = array_values($currUser2)[0][0];
    $LogID = $currUser; //$_SESSION['curr_user']; // THIS IS HARD CODED, NEEDS TO BE FIXED AT SOME POINT !!!!!
    $dateVar = date('Y-m-d H:i:s');
    $LogID .= $dateVar;
    $currUserEmail = $currUser;
    $query1 = "INSERT INTO drinklogentry VALUES (:LogID, :amount, :calories)";
    $query2 = "INSERT INTO recordentry VALUES (:LogID, :currUserEmail)";  
    $query3 = "INSERT INTO containsdrink VALUES (:drinkname, :LogID)"; // THIS IS ALSO HARDCODED AND NEEDS TO BE FIXED !!
    $cfloz = "SELECT CaloriesPerFlOz FROM drinks WHERE DrinkName = '$drinkname'";
    try {
        //echo $LogID;
        //echo $cfloz;
        $statement = $db->prepare($cfloz);
        $statement->execute();
        $result = $statement->fetch(); 
        //echo $result["CaloriesPerFlOz"];
        $statement->closeCursor();

        $statement1 = $db->prepare($query1);
        $statement1->bindValue(':LogID', $LogID);
        $statement1->bindValue(':amount', $amount);
        $statement1->bindValue(':calories', (int)$amount * (int)$result["CaloriesPerFlOz"]);
        $statement1->execute();
        $statement1->closeCursor();

        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':LogID', $LogID);
        $statement2->bindValue(':currUserEmail', $currUserEmail);
        $statement2->execute();
        $statement2->closeCursor();

        $statement3 = $db->prepare($query3);
        $statement3->bindValue(':LogID', $LogID);
        $statement3->bindValue(':drinkname', $drinkname);
        $statement3->execute();
        $statement3->closeCursor();
    }
    catch (PDOException $e) 
    {
        if (str_contains($e->getMessage(), "Duplicate"))
		   echo "Failed to add an entry. <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        echo "bugged";
    }
} 

function getAllFeelings($currUser2)
{
    //var_dump($currUser2);
    $currUser = array_values($currUser2)[0][0];
    //echo $currUser;
    global $db; 
    // THIS IS HARD CODED, NEEDS TO BE FIXED AT SOME POINT !!!!!
    $query = "SELECT * FROM userfeelings INNER JOIN recordfeelings ON userfeelings.FeelingID=recordfeelings.FeelingID WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function getAllEntries($currUser2)
{
    //var_dump($currUser2);
    $currUser = array_values($currUser2)[0][0];
    //echo $currUser;
    global $db; 
    // THIS IS HARD CODED, NEEDS TO BE FIXED AT SOME POINT !!!!!
    $query = "SELECT * FROM recordentry INNER JOIN drinklogentry ON recordentry.LogID=drinklogentry.LogID 
    INNER JOIN containsdrink on recordentry.LogID = containsdrink.LogID WHERE Email=:currUser ORDER BY calories";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function getAddress($currUser2)
{
    //var_dump($currUser2);
    $currUser = array_values($currUser2)[0][0];
    //echo $currUser;
    global $db; 
    $query = "SELECT * FROM useraddress WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function getPhone($currUser2)
{
    //var_dump($currUser2);
    $currUser = array_values($currUser2)[0][0];
    //echo $currUser;
    global $db; 
    $query = "SELECT * FROM phone WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function getUserAndPass($currUser2)
{
    //var_dump($currUser2);
    $currUser = array_values($currUser2)[0][0];
    //echo $currUser;
    global $db; 
    $query = "SELECT * FROM user WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function updateStreetNum($newNum, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE userAddress SET StreetNumber = :newNum WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":newNum", $newNum);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updateStreetName($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE userAddress SET StreetName = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updateCity($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE userAddress SET City = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updateState($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE userAddress SET StateResidence = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updateZip($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE userAddress SET ZipCode = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updatePhoneType($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE phone SET PhoneType = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}

function updatePhoneNum($new, $currUser2)
 {
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $query = "UPDATE phone SET PhoneNumber = :new WHERE Email=:currUser";
    $statement = $db->prepare($query);
    $statement->bindValue(":currUser", $currUser);
    $statement->bindValue(":new", $new);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
}


function emailTotalCalories($currUser2){
    $currUser = array_values($currUser2)[0][0];
    global $db; 
    $username = 'root';
    $password = '';
    $host = 'localhost';
    $dbname = 'drinkingBuddy';   
    $dsn = "mysql:host=$host;dbname=$dbname";  
    $connection = new mysqli($host, $username, $password, $dbname);
    $result = $connection->query("CALL TotalCalories1('$currUser')");
    //$result =$connection->fetch();
    //$connection = new PDO($dsn, $username, $password);
    //$q = $connection->exec("CALL TotalCalories1")
    $res = $result->fetch_assoc()["SUM(AmountFlOz)"];
    return $res;
}


?>