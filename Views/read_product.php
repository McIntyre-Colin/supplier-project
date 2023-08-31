<?php
require "../config.php";
require "../Controllers/read_product.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p><b><?php echo $row["description"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <p><b><?php echo $row["price"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Number of Units</label>
                        <p><b><?php echo $row["number_of_units"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <p><b><?php echo ($imgCheck == 1) ? "<img src=" . $targetFilePath . " height='150' width = '150'>" : "No image"?></b></p>
                        
                    </div>
                    <p><a href="../index.php" class="btn btn-primary">Back</a></p>
                    <p><?php echo '<a href="update_product.php?id='. $param_id .'" class="btn btn-primary"> Update </a>';?></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>