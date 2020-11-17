You can also look at this README.md file here:
https://github.com/eddydinh/Facebark
# Include in this project:
- [converpage.pdf](./coverpage.pdf) file which is our cover page.
- [setup.php](./setup.php) file that contains SQL DDL and Loading of Data.
- [documentation.pdf](./documentation.pdf) that gives a short description of our project from a business perspective, including the explanations about missed deliverables, changed deliverables, changed formal specs, changed E-R diagram or entities or relationships, unexpected challenges, new features above and beyond your formal specs, etc. 
- [analytics.php](./analytics.php) file contains code implementations of Selection, Projection, Join, Aggregation with Group By, Aggregation with Having, Nested Aggregation with Group By, Division.
- [index.php](./index.php), [timeline.php](./timeline.php), [profile.php](./profile.php), [message.php](./messgae.php) files contain code implementations of Insert, Delete, Update, Projection.
# Screenshots
# How to run locally
- Download XAMPP [here](https://www.apachefriends.org/download.html).
## For Windows:
- After you have successfully downloaded and installed XAMPP, goes to your **xampp\htdocs** folder (usually is stored in **C:\xampp\htdocs**):
![alt text](/screenshots/tutorial1.PNG)
- Then, put Facebark project here (by unziping the submitted zip file here). The **xampp\htdocs** folder should now look like this: 
![alt text](/screenshots/tutorial2.PNG)
- Run xampp-control application found in **xampp\** folder
![alt text](/screenshots/tutorial3.PNG)
- The panel should look like this
![alt text](/screenshots/tutorial4.PNG)
- Click the **Start** buttons for **Apache** and **MySQL**. Panel should now look like this:
![alt text](/screenshots/tutorial5.PNG)
- Go into your browser, and type **localhost/phpmyadmin/**. Click on **New** on the left panel.
![alt text](/screenshots/tutorial6.PNG)
- Create a database named **chatappdb** in your MySQL
![alt text](/screenshots/tutorial7.PNG)
- Go into your browser, and type **localhost/Facebark/setup.php**. You should see this output:
![alt text](/screenshots/tutorial8.PNG)
- In your browser, now type **localhost/Facebark** to run the project.


