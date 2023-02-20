
<?php
require_once('database.php');

// Get IDs
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
//Get Ctegory Name

$category_name = filter_input(INPUT_POST, 'category_name');

// Delete the category from the database
if ($category_id != null) {
    //check category in the product lsit
       $sql = "SELECT * FROM categories 
            WHERE categoryID in (select categoryID from  products) and  categoryName = :category_name";
 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue("category_name", $category_name);
    $stmt->execute();
    $category = $stmt->fetch();
    $stmt->closeCursor();   

    if ($category) {
       
       $error = "The category ". $category_name  ." cannot be deleted since there exist products in that category.";
       include('error.php');
    } 
    else
    {
    $query = 'DELETE FROM categories
              WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id );
    $success = $statement->execute();
    $statement->closeCursor(); 
    include('category_list.php');
    }
}
else 
{
    echo $category_id;
    //include('index.php');
}

// Display the Product List page


?>

