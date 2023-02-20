<?php
$category_name = filter_input(INPUT_POST, 'category_name');

// Validate inputs
if ($category_name == null) {
    $error = "Invalid category data. Check the fields and try again.";
    include('error.php');
} else {
    require_once('database.php');
    //Check category is already exist
    $sql = "SELECT * FROM categories
                  WHERE categoryName = :category_name";
 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue("category_name", $category_name);
    $stmt->execute();
    $category = $stmt->fetch();
    $stmt->closeCursor(); 

    if ($category) {
       $error = "The category ". $category_name .  " already exist already ";
       include('error.php');
    } 
    else
    {
    // Add the category to the database  
    $query = 'INSERT INTO categories
                 (categoryName)
              VALUES
                 (:category_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category_name);
    $statement->execute();
    $statement->closeCursor();

    // Display the category List page
    include('category_list.php');
    }
    
}
?>
