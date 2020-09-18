# PHP-music-database
Small and simple music database web app for Web app development with PHP / SQL - course

This project is an web application for music enthusiasts to collect data about various artists, their members, different genres, albums etc.
There is a simple UI for adding, updating and deleting the meantioned data types. Only thing that is not implemented is adding different types of roles
for members, but the ones added in the SQL data file should be somewhat sufficient. 

Deployment instructions:

1. Download and install XAMPP and start Apache server and MySQL database functions.
2. Download the zip-file from the github repository.
3. Unzip the file and move the "phpapp" folder to your XAMPP folder "htdocs".
4. Open "http://localhost/phpmyadmin" in your browser to access the MySQL server.
5. Open the "SQL-files" folder in phpapp to find "SQLCreateTablesAndData" - file.
5. Open mysql tab and open the SQL query window, add the text from "SQLCreateTablesAndData" - file to the query field and run it.
6. The app is ready for use at "http://localhost/phpapp".
