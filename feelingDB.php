<?php 
 function addFeeling($feelingValue)
{
    global $db;
    $feelingID = $_SESSION['curr_user'] + date('d-m-y h:i:s');
    $query = "INSERT INTO userfeelings VALUES (:feelingID, :feelingValue)";  
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':feelingValue', $feelingValue);
        //$statement->bindValue(':caloriesperfloz', $caloriesperfloz);
        $statement->execute();
        $statement->closeCursor();

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

function getAllFeelings()
{
    global $db; 
    $query = "SELECT * FROM userfeelings";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();   // fetch()
    $statement->closeCursor();
    return $result;
}

function deleteFeeling($FeelingID)
{
    global $db; 
    $query = "DELETE FROM userfeelings WHERE FeelingID=:FeelingID"; 
    $statement = $db->prepare($query); 
    $statement->bindValue(':FeelingID', $FeelingID); 
    $statement->execute(); 
    $statement->closeCursor(); 
}
?> 