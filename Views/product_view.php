<?php
// Include required files (yeehaw, reusing code blocks :D)
include "../config.php";
require "../Controllers/read_product.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="CSS/product_view.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
    <div class="wrapper">
    <h1 class="title">Product Information</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="product-name">
                        <label><b>Product</b></label>
                        <p><?php echo $row["name"]; ?></p>
                    </div>

                    <div class="image">
                        <p><b><?php echo ($imgCheck == 1) ? "<img src=" . $targetFilePath . " height='150' width = '150'>" : "No image"?></b></p>                       
                    </div>
                    <div class="select">
                        <select id="quantity" onchange="updateQuantity()">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div> 
                </div>

                <div class="col-md-8">
                <div class="product-description">
                        <label>Product Description</label>
                        <p><?php echo $row["description"]; ?></p>
                    </div>
                    <div class="product-price">
                        <label>Price</label>
                        <p><?php echo $row["price"]; ?></p>
                    </div>
                <div class="product-in-stock">
                        <label>Units In Stock!</label>
                        <p><?php echo $row["number_of_units"]; ?></p>
                    </div>
                    <p><b><span id = "num"></span> Ready to add to cart!</b></p>
                    <p><?php echo '<a href="" class="btn btn-primary"> Add to Cart </a>';?></p>
                    <p><a href="customer_index.php" class="btn btn-primary">Back</a></p>

                </div>
   
 
            </div>        
        </div>
    </div>
</body>
<script>
    function updateQuantity() {
      var value = document.getElementById("quantity").value;
      document.getElementById('num').innerHTML = value;
    }
   </script>
</html>