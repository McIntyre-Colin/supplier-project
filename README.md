Header Info:
    Project - Supplier Dashboard
    Developer - Colin McIntyre

Application Info:
    Software used - PHP, SQL (MySQL), CSS, HTML, GIT, Apache2, bash, JS
    Resources - https://www.tutorialrepublic.com/php-tutorial/php-mysql-connect.php
                Used this as a guide for connecting mysql database as well as a PHP guide for crud applications

    
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


    
    