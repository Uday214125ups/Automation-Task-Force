# Automation Task Force
 
To run this project on local device, WAMP needs to be installed along with all versions of Microsoft Visual C++.

After that create a db in mysql console of wamp server, and also create a user table where we have to store authenticated users; use the below mentioned schema for user table:
mysql> desc users;
+----------+--------------+------+-----+---------+-------+
| Field    | Type         | Null | Key | Default | Extra |
+----------+--------------+------+-----+---------+-------+
| email    | varchar(100) | YES  |     | NULL    |       |
| username | varchar(100) | YES  |     | NULL    |       |
| password | varchar(100) | YES  |     | NULL    |       |
+----------+--------------+------+-----+---------+-------+

Change the details of localhost and db name in db.php file, after that you are good to go to run the project.
