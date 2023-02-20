<?php
require('database.php');
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();


// Get the product data
$edit_product_id = filter_input(INPUT_POST, 'edit_product_id', FILTER_VALIDATE_INT);
$edit_category_id = filter_input(INPUT_POST, 'edit_category_id', FILTER_VALIDATE_INT);
$code = filter_input(INPUT_POST, 'edit_code');
$name = filter_input(INPUT_POST, 'edit_name');
$price = filter_input(INPUT_POST, 'edit_price', FILTER_VALIDATE_FLOAT);
//get category Name
$sql = 'SELECT *
          FROM categories where  categoryID = :category_id';
$stat = $db->prepare($sql);
$stat->bindValue("category_id", $edit_category_id);
$stat->execute();
$categoryName = $stat->fetchAll();
$stat->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Product Manager</h1></header>

    <main>
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="post"
              id="add_product_form">
 
 <input type="hidden" name="product_id" value="<?php echo $edit_product_id ?>"><br>
 
            <label>Category:</label>
            <select name="category_id">
                 <?php foreach ($categoryName as $cat_Name) : ?>
                <option value="<?php echo $cat_Name['categoryID']; ?>">
                    <?php echo $cat_Name['categoryName']; ?>
                </option>
            <?php endforeach;?>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select><br>

            <label>Code:</label>
            <input type="text" name="code" value="<?php echo $code ?>"><br>

            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $name ?>"><br>

            <label>List Price:</label>
            <input type="text" name="price" value="<?php echo $price ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Edit Product"><br>
        </form>
        <p><a href="index.php">View Product List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>

