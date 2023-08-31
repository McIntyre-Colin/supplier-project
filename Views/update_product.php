<?php
// Include Required files
require "../config.php";
require "../Controllers/update_product.php";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the PRODUCT record.</p>
                    <!-- html special characters to prevent cross site scripting -->
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo $name; ?>" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" value="<?php echo $description; ?>" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Units</label>
                            <input type="number" name="number_of_units" value="<?php echo $number_of_units; ?>" class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_units; ?>">
                            <span class="invalid-feedback"><?php echo $number_of_units_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price per Unit</label>
                            <input type="text" name="price" value="<?php echo $price; ?>" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <p><b><?php echo ($imgCheck == 1) ? "<img src=" . $targetFilePath . " height='150' width = '150'>" . " " . $imgName ."" : "No image"?></b></p>
                            <input type="file" id="file_button" name="file" value="<?php echo $imgName; ?>" hidden>
                            <label for="file_button" class="btn btn-primary">Change Image</label>
                            <span id="file_chosen">No file chosen</span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>

    <script>
        // This allows for the image to be updates

        const fileBtn = document.getElementById('file_button');

        const fileChosen = document.getElementById('file_chosen');

        fileBtn.addEventListener('change', function(){
        fileChosen.textContent = this.files[0].name
        })


    </script>
</html>