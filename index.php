<?php
session_start();

  $servername = "localhost";
  $username = "krood20";
  $password = "Soccer22!";
  $dbname = "krood20";

$connect = mysqli_connect($servername, $username, $password, $dbname);

//checks if you added to the cart
if(isset($_POST["add_to_cart"]))
{
    //set the update stock variables
    $value = $_POST["quantity"];
    $vname = $_POST["hidden_name"];
    $update = "UPDATE products SET products.stock = products.stock - '$value' WHERE products.name = '$vname'";
    mysqli_query($connect, $update);

	//error handling
    if (mysqli_query($connect, $sql)) {
      echo "Record updated successfully";
    }
    else {
      echo "Error updating record: " . mysqli_error($connect);
    }
	
	//shopping cart session variable
    if(isset($_SESSION["shopping_cart"]))
    {
        //getting something from array
         $item_array_id = array($_SESSION["shopping_cart"], "item_id");
         if(!in_array($_GET["id"], $item_array_id))
         {
              //making an array of parameters
              $count = count($_SESSION["shopping_cart"]);
              $item_array = array(
                   'item_id' => $_GET["id"],
                   'item_name' => $_POST["hidden_name"],
                   'item_price' => $_POST["hidden_price"],
                   'item_category' => $_POST["hidden_category"],
                   'item_quantity' => $_POST["quantity"]
              );
              $_SESSION["shopping_cart"][$count] = $item_array;
         }
		//if an item has already been added
         else
         {
              echo '<script>alert("Item Already Added")</script>';
              echo '<script>window.location="index.php"</script>';
         }
    }
    else
    {
         $item_array = array(
              'item_id' => $_GET["id"],
              'item_name' => $_POST["hidden_name"],
              'item_price' => $_POST["hidden_price"],
              'item_category' => $_POST["hidden_category"],
              'item_quantity' => $_POST["quantity"]
         );
         $_SESSION["shopping_cart"][0] = $item_array;
    }
}

//checks if you pressed the remove from cart button
if(isset($_GET["action"]))
{
    //add back to stock
    $update1 = "UPDATE products SET products.stock = products.stock + '$value' WHERE products.name = '$vname'";
    //mysqli_query($connect, $update1);

    if($_GET["action"] == "delete")
    {

         foreach($_SESSION["shopping_cart"] as $keys => $values)
         {
              if($values["item_id"] == $_GET["id"])
              {

                   unset($_SESSION["shopping_cart"][$keys]);
                   echo '<script>alert("Item Removed")</script>';
                   echo '<script>window.location="index.php"</script>';
              }
         }
    }
}

//html and php
?>
<!DOCTYPE html>
<html>
    <head>
         <title>Kyle's Place</title>
    </head>
    <body>
         <br />
         <div class="container" style="width:700px;">
              <h3 align="center">Welcome to Kyle's Place</h3><br />
                <h4 align="center">The place for memes, groceries, and all your tech needs!</h4><br/>

                <form action="" method="post">
                  <input type="text" name="search">
                  <input type="submit" name="submit" value="Search">
                </form>

              <?php
              //set the initial query values
              $search_value=$_POST["search"];
              $query = "SELECT * FROM products ORDER BY id ASC";
              $query1 = "SELECT * FROM price ORDER BY id ASC";
		
		//search by category
              if($search_value == 'meme' or $search_value == 'food' or $search_value == 'tech'){
                  $query="SELECT * FROM products WHERE category LIKE '%$search_value%'";
              }
		//search by name
              else if($search_value == 'Broccoli' or $search_value == 'Carrot' or $search_value == 'Potato' or $search_value == 'Fish' or
                  $search_value == 'Steak' or $search_value == 'Mango' or $search_value == 'Bread' or $search_value == 'Computer' or
                  $search_value == 'Power_Cable' or $search_value == 'Case' or $search_value == 'Headphones' or $search_value == 'Printer' or
                  $search_value == 'USB' or $search_value == 'Speaker' or $search_value == 'Pepe' or $search_value == 'Turtle_Kid' or
                  $search_value == 'Nick_Cage' or $search_value == 'Knuckles' or $search_value == 'Dwight' or $search_value == 'Why_you_lyin' or
                  $search_value == 'Arthur_Fist'){

                  $query = "SELECT * FROM products WHERE name LIKE '%$search_value%'";

              }
		//if nothing matches get all the products
              else{
                  $query = "SELECT * FROM products ORDER BY id ASC";
              }

              $result = mysqli_query($connect, $query);
              $result1 = mysqli_query($connect, $query1);

              //error handling for a failed connection
              if (mysqli_connect_errno()){
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  //you need to exit the script, if there is an error
                  exit();
              }

                //general store page --> check if this if statement is right
                if(mysqli_num_rows($result) > 0 and mysqli_num_rows($result1) > 0)
                {
                	//while loop to put all of the items in the store
		     while($row = mysqli_fetch_array($result) and $row1 = mysqli_fetch_array($result1))
                     {
                

		?>


                <div class="col-md-4">
                     <form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
                          <div style="border:1px solid #333; border-radius:5px; padding:16px;" align="center">
                               <h4 class="text-info"><?php echo $row["name"]; ?></h4>
                               <h4 class="text-danger">$ <?php echo $row1["price"]; ?></h4>
                               <h4 class="text-danger">Category: <?php echo $row["category"]; ?></h4>
                               <h4 class="text-danger">Stock: <?php echo $row["stock"]; ?></h4>
                               <input type="number" name="quantity" class="form-control" value="0" min="1"/>
                               <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
                               <input type="hidden" name="hidden_category" value="<?php echo $row["category"]; ?>" />
                               <input type="hidden" name="hidden_price" value="<?php echo $row1["price"]; ?>" />
                               <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                          </div>
                     </form>
                </div>
                <?php
                     }
                }
			
		//the cart: all of the things you have ordered
              ?>
              <div style="clear:both"></div>
              <br />
              <h3>Order Details</h3>
              <div class="table-responsive">
                   <table class="table table-bordered">
                        <tr>
                             <th width="20%">Item Name</th>
                             <th width="20%">Quantity</th>
                             <th width="20%">Price</th>
                             <th width="15%">Total</th>
                             <th width="20%">Action</th>
                        </tr>
                        <?php
                        if(!empty($_SESSION["shopping_cart"]))
                        {
                             $total = 0;
                             foreach($_SESSION["shopping_cart"] as $keys => $values)
                             {
                        ?>
                        <tr>
                             <td><?php echo $values["item_name"]; ?></td>
                             <td>-------><?php echo $values["item_quantity"]; ?></td>
                             <td>$ <?php echo $values["item_price"]; ?></td>
                             <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                             <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                        </tr>
                        <?php
				//calculate the totals for each item
                                  $total = $total + ($values["item_quantity"] * $values["item_price"]);
                             }
                        ?>
                        <tr>
                             <td colspan="3" align="right">Total</td>
                             <td align="right">$ <?php echo number_format($total, 2); ?></td>
                             <td></td>
                        </tr>
                        <?php
                        }
                        ?>
                   </table>
              </div>
         </div>
         <br />
    </body>
</html>
