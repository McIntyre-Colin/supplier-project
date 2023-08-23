CREATE TABLE products (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    number_of_units INT NOT NULL,
    price VARCHAR(10) NOT NULL,
    image LONGBLOB DEFAULT NULL
);

INSERT into products (name, description, number_of_units, price) VALUES ('Test Product', 'This is a test description for the test product. Will mess with the image upload later', '100', '19.99');


CREATE TABLE images (
  id INT NOT NULL AUTO_INCREMENT,
  file_name varchar(255) NOT NULL,
  uploaded_on datetime NOT NULL,
  status tinyint(1) NOT NULL DEFAULT 1,
  product_id INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

 $query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

                    if($query->num_rows > 0){
                        while($row = $query->fetch_assoc()){
                            $imageURL = 'uploads/'.$row["file_name"];
                    ?>
                        <img src="<?php echo $imageURL; ?>" alt="" />
                    <?php }
                    }else{ ?>
                 
                   <p>No image(s) found...</p>
                    <?php }

BEGIN TRANSACTION
   DECLARE @id int;
   INSERT INTO products etc etc
   SELECT @id = scope_identity();
   INSERT INTO images VALUES (@id);
COMMIT

insert into images values
(scope_identity(), @id)