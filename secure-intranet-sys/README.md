Steven De Jesus

Secure Intranet System

02/13/2024

## Description of program:

This program is a web application (using flask) for an intranet system where engineers, accountants, admins, and other guests are able to travel through the system to different areas, with different access levels governing what areas they can access. At each level in the system, authentication exists to verify the user belongs there. For example, the user cannot move forward to the menu without logging in successfully (can't even brute force it through the url) without the system redirecting them to log in. Then, before the user enters each area, their access level is verified to make sure they have the correct privileges. The access level of the current session's user is saved throughout the system until they willfully log out. All data such as usernames, passwords, and access levels are stored in a database which utilizes parametrized queries, ensuring that manipulation of the data is not possible. All passwords are hashed with the SHA-1 algorithm and are salted, then verified using an authentication method which verifies if hashed password exists in the database.

In this program, a user is able to either log into an existing account, or sign up for a new one. The user gets three unsuccessful attempts before being sent to "jail", where they're locked out. But, from there, they can try to log in again with a blank slate, so they're not permanently locked out. When signing up, a user could either choose their own password or generate a strong password using a password generator function. The user would then have the access level of guest, and can only access the time reporting area and the IT help desk. There are presaved accounts of an engineer, accountant, and admin, which have their own privileges.

## Setting up program:

As it is now, the database is not set up so all you would have to do is run app.py, and the database file will automatically run since it is imported. It calls create_db, which creates and initializes the database using the methods from database.py. Initializing it creates a secret key for the app to keep session information, and three accounts. An account for an engineer, an accountant, and an admin. From there, both the flask app and its constituents and the database are set up and ready to use. Unless you manually drop the table using the function in the database file, it creates itself and initializes itself only once, and does not impede with existing and added data.

## Testing program:

To test the program, there are a few commented out lines of code at the end of database which calls each function to make sure it all works. All other methods in the other files were tested thoroughly to make sure the functionality and logic works before being integrated with flask, so there are no extra testing suites for those.

## Running program:

To run the program, run as normal as it automatically sets up the database and all flask components at the start of the program run. To create your own user, click the sign up link at the bottom of the login page and input a username between 3 and 15 characters, with both numbers and letters. For your password, you can select the option of generating your own password or creating your own password. To create your own password, it must be between 8 and 25 characters, and must have one uppercase letter, lowercase letter, number, and special character. If you generate your own password, make sure to keep note of it since it doesn't transfer pages. Once signed up successfully, click the link to the login page, log in, and explore the menu. If you cannot log in with three tries, you are sent to jail where you are "locked out". For this project you're not actually locked out so that you can continue to play around with it, so scroll down and click the link back to the login page. 

To sign on with the other accounts, engineer, accountant, and admin, their credentials are located in testing_creds.txt, an extra file in this project just for the grader to play around with the different accounts.

## Foreign code used:
Hash and authentication functions from the Cybersecurity Principles class at the University of Vermont, authored by Professor James Eddy.

All images sources right under each image.