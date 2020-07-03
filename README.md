Phramework
---
by Fhiz<br>

Summary
---


Quick Start
---

1. Make sure you have a web host available that meets all requirements.
* Requirements include: PHP7, op_cache enabled, database available

1. Unzip the ZIP archive locally and get ready to edit a bunch of files.
* Browse to the Data/Config folder, all configuration is done there.

2. Edit "BaseConfig.class.php" found in: Data/Config/AbstractConfig/
* Set the "DOMAIN" constant to your app domain (including http://)
* Set the "ROOT" constant to your projects root folder ("Phramework" by default)

3. Edit "DatabaseConfig.class.php" found in: Data/Config/ManagerConfig
* Configure all database constants to allow your app using the database.
* Please see your host documentation about how to obtain those credentials.

4. Edit "MailConfig.class.php" found in: Data/Config/ManagerConfig/
* Configure all constants in this file to allow your app sending emails to users.
* Please see your host documentation about how to obtain those credentials.

5. Upload the complete project folder to your domain.
* The folder is named "Phramework" by default and should be uploaded to your domain root.

6. Open the Install page in your browser: "YOURDOMAIN.COM/Phramework/?p=0"
* This will run the installation process and initializes the database.
* Make sure to rename the "Install" directory afterwards, or delete it.
* Running installation again will reset the database to its default.

7. Open the index page in your browser register an account: "YOURDOMAIN.COM/Phramework/?p=1"
* Finally login and have fun playing around with Phramework.

Requirements/Compatibility
---
* This project requires a PHP7 capable host!
* Client: Any hardware/OS/Browser that is HTML5 and CSS3 capable
* Server: Moderately powerful web-host, PHP7, mySQL or any other database, op_cache