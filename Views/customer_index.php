<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Products for Sale</h2>
                        <a href="../index.php" class="btn btn-secondary pull-right"><i class="fa"></i>Supplier View</a>
                    </div>
                    <?php
                    // Include config file
                    include "../config.php";
                    $targetDir = "../uploads/";
        
                    //Product Query
                    $sql = "SELECT * FROM products";
                    $imgSql = "SELECT * FROM images where product_id = ?";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){

                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Image</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Action</th>";
                                        // Where you could have additional columns be displayed
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    $param_id = $row['id'];
                                    //Image pull
                                    $imgStmt = mysqli_prepare($conn, $imgSql);
                                    mysqli_stmt_bind_param($imgStmt, "i", $param_id);
                                    mysqli_stmt_execute($imgStmt);
                                    $imgResult = mysqli_stmt_get_result($imgStmt); 
                                    
                                    $imgRow = mysqli_fetch_array($imgResult, MYSQLI_ASSOC);
                                    $imgName = $imgRow["file_name"];

                                    $targetFilePath = $targetDir . $imgName;

                                    echo "<tr>";
                                        echo "<td> <img src=" . $targetFilePath . " height='50' width = '50'> </td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="product_view.php?id='. $row['id'] .'" class="mr-3" title="View Product" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="" class="mr-3" title="Add to Cart" data-toggle="tooltip"><span class="fa fa-shopping-cart"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            // Frees the memory associated with the result
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>