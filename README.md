# Supplier Dashboard
This project is designed to demonstrate proficiency with the LAMP stack. It allowes suppliers/sellers to create items and have them entered into a database. There is also an option for a consumer view and the consumer functionality is built such that it could be expanded in the future

## Software Used 
    Software used - PHP, SQL (MySQL), CSS, HTML, GIT, Apache2, bash, JS
    Resources - https://www.tutorialrepublic.com/php-tutorial/php-mysql-connect.php
                Used this as a guide for connecting mysql database as well as a PHP guide for crud applications

## File Structure
    The code is organized into a standard MCV format. Models handle database operations, Controllers handle data validation and all the business logic to ensure the models are getting the correct information, and the Views are the HTML and CSS files for each landing page.

    For the sake of visual clarity, all of the CRUD operations have been seperated out into their own files. In practice they would be in one file and broken down into seperate functions. Currently there is no seperation for files serving the supplier and the customer as I did not want to have a lot of file trees, however it would be a trivial matter to create a new set of MVC directories in a "customer" directory.

## File Explaination
    **config.php** handles the connection to the MySQL database.
    **index.php** is the main landing page for the project. As this project is a dashboard for suppliers, **index.php** takes the user directly to the page where all product information is displayed.
    **suppliers.sql** is the phpmyadmin dump of the database structure and set up.

## Orienting Yourself in the Code
    Everything begins in **index.php**. From there the user has the option to perform any CRUD operation. Their selection will send them to the View for that specific operation. The Controller for that operation will immediatly be triggered as well.
    ``` php
        include "../config.php";
        require "../Controllers/read_product.php";
    ```
    The controller will then go about sending or reviecing data from the database by calling functions from the pertanant Model file based on the actions of the user. When the operation is complete the user will be redirected (or prompted to go) to the main landing page, **index.php**.

    Since all CRUD operations follow the same schema, this process is identical across all parts of the codebase.

## Image Uploading and Updating
    
Progress:
It took quite some time to get up to speed with PHP and MySQL as this was my first time working with both Softwares.
And getting my environment set up was a fun and challenging process as well. Specifically getting phpmyadmin to have the correct permissions.
The guide above was very useful for providing a framework within to operate and adapt for this specific project.
A main focus of the design was adaptability and allowing for parameters and data to be changed easily if that is what 
the group decided to go with. Additionally I tried to use clear varaible names and add comments wto describe code blocks.
A useful development tool for me was the use of echo statements. They allowed to me see where in the code problems were arising,
and to check what values were actually being stored and transmitted. These instances have been removed for code legibility. 
In the future I would use a PHP debugger to make the dev process a little bit smoother.

Current functionality of the Application allows suppliers to create and upload a product with the following information:
-Name of the product
-Product Description
-Price of the product
-Number of units for the product
-Image(s) for the product

The user can also view and update and delete product information.
Some error checking has been implemented, currently the error checking for the images is non-existent and that has caused some problems during the update process.

Next Steps:
    Supplier IDs - With the addition of a users table where suppliers have their own ID it would be a trivial matter to add a home page for the suppliers where
                   a sql "where" statement is used to pull only the products created by that user.
    Images - Currently the database is set up to have a many:1 relationship for images. One product can have many images. I have yet to implement that in the code 
             specifically because I'm having trouble updating the existing image entry and I do not want to complicate matters further, but the DB infrastructure is there.

Included is the "suppliers.sql" file which is the structure export from phpmyadmin
edit.sql is solely for editing and playing around with SQL commands


    
    