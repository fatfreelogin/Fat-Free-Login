# Fat Free Login

Simple login script based on Fat Free Framework.
The script offers the following possibilities: 
- registration 
- a confirmation link is sent to the user's email 
- after clicking the link the account gets activated
- users can change password
- lost password retrieval
- access to pages is controlled by f3-access
- automatic logout after configurable amount of time 
- admin section with user management
- csrf protection (in /app/controllers/Controller.php)
- error logs and access logs in /logs

## Getting started

### Prerequisites

Fat Free Framework 3.6 (https://github.com/bcosca/fatfree)
F3-access (https://github.com/xfra35/f3-access , located in the lib folder)
PHPMailer (located in the lib folder)

### Installing

1. Install the Fat Free Framework (https://fatfreeframework.com/3.6/home), then copy all the files of this script to same folder.

2. Copy the access.php file from https://github.com/xfra35/f3-access/tree/master/lib to the lib folder

3. Copy PHPMailer to the lib folder (https://github.com/PHPMailer/PHPMailer/tree/master/src)

4. Install the mysql database using /db/create_db.sql

5. Set the /config/config.ini file:
- DEBUG (0, 1, 2 or 3)
- ssl (http:// or https://)
- auto_logout time (automatically log out user after so many seconds of inactivity)
- database settings
- mail smtp settings

Active login is admin:fatfree123

## Contributing
This script is offered as is. 
Feel free to contribute to this and update as you like.