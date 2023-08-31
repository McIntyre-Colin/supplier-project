
<?php
// Include config file
// Refactored into MVC format (this is the view)
require "../config.php";
require "../Controllers/create_product.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Product Record</h2>
                    <p>Please fill this form and submit to add your product to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                            <!-- Using bootstrap form contol errors to create popups if the user enters invalid data -->
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Units</label>
                            <input type="number" name="number_of_units" class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_units; ?>">
                            <span class="invalid-feedback"><?php echo $number_of_units_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price per Unit</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="file" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>