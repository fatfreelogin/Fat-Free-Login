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
- csrf protection (in controllers/Controller.php)
- error logs and access logs in /Fat-Free-Login/logs

## Getting started

### Prerequisites

Fat Free Framework 3.6 (https://github.com/bcosca/fatfree)
F3-access (https://github.com/xfra35/f3-access) located in /vendor/xfra35/f3-access
PHPMailer 6.0.7 (https://github.com/PHPMailer/PHPMailer) located in /vendor/phpmailer/phpmailer

### Installing

1. Install this repository on your webserver

2. Set the /config/config.ini file:
- DEBUG (0, 1, 2 or 3)
- ssl (http:// or https://)
- auto_logout time (automatically log out user after so many seconds of inactivity)
- database settings
- mail smtp settings

3. install the example database: located in Fat-Free-Login/db/create_db.sql
	
	mysql -uUSER -pPASSWD
	create database fatfreelogin
	source create_db.sql

4. Active login is admin:fatfree123


## Contributing
This script is offered as is. 
Feel free to contribute to this and update as you like.
