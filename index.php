<?php
session_start();

  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "krood20";

$connect = mysqli_connect($servername, $username, $password, $dbname);

//checks if you added to the cart
if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        //getting something from array
         $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
         if(!in_array($_GET["id"], $item_array_id))
         {
              //making an array of parameters
              $count = count($_SESSION["shopping_cart"]);
              $item_array = array(
                   'item_id'               =>     $_GET["id"],
                   'item_name'               =>     $_POST["hidden_name"],
                   'item_price'          =>     $_POST["hidden_price"],
                   'item_category'          =>     $_POST["hidden_category"],
                   'item_quantity'          =>     $_POST["quantity"]
              );
              $_SESSION["shopping_cart"][$count] = $item_array;
         }
         else
         {
              echo '<script>alert("Item Already Added")</script>';
              echo '<script>window.location="index.php"</script>';
         }
    }
    else
    {
         $item_array = array(
              'item_id'               =>     $_GET["id"],
              'item_name'               =>     $_POST["hidden_name"],
              'item_price'          =>     $_POST["hidden_price"],
              'item_category'          =>     $_POST["hidden_category"],
              'item_quantity'          =>     $_POST["quantity"]
         );
         $_SESSION["shopping_cart"][0] = $item_array;
    }
}

//checks if you pressed the remove from cart button
if(isset($_GET["action"]))
{
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
              $query = "SELECT * FROM products ORDER BY id ASC";
              $query1 = "SELECT * FROM price ORDER BY id ASC";
              $result = mysqli_query($connect, $query);
              $result1 = mysqli_query($connect, $query1);

              //error handling for a failed connection
              if (mysqli_connect_errno()){
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                  //you need to exit the script, if there is an error
                  exit();
              }

              //search the database --> one query for the categories and one for the names
              $search_value=$_POST["search"];
              $sql="SELECT * FROM products WHERE category LIKE '%$search_value%'";
              $sql1="SELECT * FROM products WHERE name LIKE '%$search_value%'";
              $result3 = mysqli_query($connect, $sql);
              $result4 = mysqli_query($connect, $sql1);

                //general store page --> check if this if statement is right
                if(mysqli_num_rows($result) > 0 and mysqli_num_rows($result1) > 0)
                {
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
                               <input type="text" name="quantity" class="form-control" value="1" />
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
                                  //update the stock
                                  //$row["stock"] = "UPDATE stock SET products.stock = products.stock - '$values["item_quantity"]'";

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
