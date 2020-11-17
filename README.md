You can also look at this README.md file here:
https://github.com/eddydinh/Facebark
# This project includes:
- [coverpage.pdf](./coverpage.pdf) file which is our cover page.
- [setup.php](./setup.php) file that contains SQL DDL and Loading of Data.
- [documentation.pdf](./documentation.pdf) that gives a short description of our project from a business perspective, including the explanations about missed deliverables, changed deliverables, changed formal specs, changed E-R diagram or entities or relationships, unexpected challenges, new features above and beyond our formal specs, etc. 
- [analytics.php](./analytics.php) file contains code implementations of Selection, Projection, Join, Aggregation with Group By, Aggregation with Having, Nested Aggregation with Group By, Division.
- [index.php](./index.php), [timeline.php](./timeline.php), [profile.php](./profile.php), [messages.php](./messages.php) files contain code implementations of Insert, Delete, Update, Projection.
# Screenshots
- Run **setup.php**
![alt text](/screenshots/tutorial8.PNG)
- Signing up for an account (**INSERT** operation):
![alt text](/screenshots/s1.PNG)
![alt text](/screenshots/s2.PNG)
- Log in using that account:
![alt text](/screenshots/s3.PNG)
![alt text](/screenshots/s4.PNG)
- Create new dog's profile (**INSERT** and **PROJECTION** and **SELECTION** operations):
![alt text](/screenshots/s5.PNG)
![alt text](/screenshots/s6.PNG)
- Go into new dog's profile (**SELECTION** operations):
![alt text](/screenshots/s7.PNG)
- Change profile picture:
![alt text](/screenshots/s8.PNG)
![alt text](/screenshots/s9.PNG)
- Add some posts (**INSERT** and **PROJECTION** and **SELECTION** operations):
![alt text](/screenshots/s10.PNG)
![alt text](/screenshots/s11.PNG)
- Change post's caption (**UPDATE** operation):
![alt text](/screenshots/s12.PNG)
![alt text](/screenshots/s13.PNG)
- Post some comment (**INSERT** and **PROJECTION** and **SELECTION** operations):
![alt text](/screenshots/s14.PNG)
![alt text](/screenshots/s15.PNG)
- Delete post (**DELETE ON CASCADE** operation):
![alt text](/screenshots/s16.PNG)
- Go into analytics:
![alt text](/screenshots/s17.PNG)
- **SELETION** and **PROJECTION** operation:
![alt text](/screenshots/s18.PNG)
![alt text](/screenshots/s19.PNG)
- **JOIN** operation:
![alt text](/screenshots/s20.PNG)
![alt text](/screenshots/s21.PNG)
- **Aggregation with Group By Distinct** operation:
![alt text](/screenshots/s22.PNG)
![alt text](/screenshots/s23.PNG)
- **Aggregation with HAVING** operation:
![alt text](/screenshots/s24.PNG)
![alt text](/screenshots/s25.PNG)
- **Nested Aggregation with Group By** operation:
![alt text](/screenshots/s26.PNG)
![alt text](/screenshots/s27.PNG)
- **Division** operation:
![alt text](/screenshots/s28.PNG)
- Go to message tab:
![alt text](/screenshots/s29.PNG)
- Send a message:
![alt text](/screenshots/s30.PNG)
![alt text](/screenshots/s31.PNG)
- On receiver side:
![alt text](/screenshots/s32.PNG)
# How to run locally
- Download XAMPP [here](https://www.apachefriends.org/download.html).
## For Windows:
- After you have successfully downloaded and installed XAMPP, goes to your **xampp\htdocs** folder (usually is stored in **C:\xampp\htdocs**):
![alt text](/screenshots/tutorial1.PNG)
- Then, put Facebark project here (by unziping the submitted zip file here). The **xampp\htdocs** folder should now look like this: 
![alt text](/screenshots/tutorial2.PNG)
- Run xampp-control application found in **xampp** folder
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


