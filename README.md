# How to Setup

### What you will need:
- vscode
- xampp
- Github extension for vscode
- PHP extension for vscode (Optional)

## How to install XAMPP

1. You need to download XAMPP to begin the setup:

> https://www.apachefriends.org/

2. Follow the download as normal
- Note: Be sure to uncheck the prompt below when downloading:
> Do you want to start the Control Panel now?

3. Find where you downloaded your XAMPP and pin "xampp-control.exe" to your taskbar (for convenience)
> xampp > xampp-control.exe

4. Start up xampp-control.exe

5. Click start for the following:
> - Apache
> - MySQL

## How to setup vscode (Assuming you already have vscode)
1. On vscode, enter the following:
- Note: Remember where your path is located at
> git clone "https://github.com/Water-Wiki/Water-Wiki.git"

- Note: If an error occurs when starting MySQL, do the following steps:
> 1. Change data folder name to
>> data_old
>
> 2. Create a new file name
>> data
>
> 3. Copy everything inside "backup" folder
> 4. Paste everything into "data" folder
> 5. Copy "test" and the folder you added from the repository from "data_old" folder
> 6. Paste into "data" folder
> - Note: You will need to replace the folder when prompted
> 7. Copy "ibdata1" file from "data_old" folder
> 8. Paste into "data" folder and replace

2. Rename the folder you cloned to
> htdocs

3. Delete "htdocs" folder inside the "xampp" folder and replace it with the cloned "htdocs" folder
4. Type localhost using any browser and begin the program inside Main.php.

## And you should be all set!

## Adding dummy data
2 Methods

1. Fast and preset data

>- Locate "SQL Starter Execution" in clone folder or on Github repository and copy its content
>- When XAMPP is started, enter "localhost/phpmyadmin" into your browser
>- Locate "SQL" on one of the top tabs and paste the content
>- Press go to start execution

2. Slow and random data generator
> The script creates
>- 50 users in sequence
>- 50 badges randomly assigned to users
>- 200 pages randomly assigned to categories with Lorem ipsum text
>- 50 forum posts assigned to random users with Lorem ipsum text
>- 250 comments randomly assigned to users and pages with Lorem ipsum text
>- 100 comments randomly assigned to users and forums with Lorem ipsum text
>- 150 likes randomly assigned to users and comments
>- 100 dislikes randomly assigned to users and comments
>- 50 stars randomly assigned to users and receivers

If the script takes too long, you may need to increase the time out value in MySQL under Edit → Preferences → SQL Editor → DBMS connection read time out.

#### Contributors
>
> - Andy Nguyen: Backend of home page, forums, pages, comments, like/dislike, reply, and database lists
> - William Tran: Frontend of all pages, script for creating dummy values
> - Zach Bernales: Front and Backend of profile page, 
> - Ravi G: Designed the SQL schema and XAMPP MySQL database for the project. Made frontend HTML/CSS templates for the Profile Page including the About Me (Bio), Message Wall, and Activity Log (later refined by William). Created the meeting minutes and slides of the project. Created the insertion scripts for the tables. Collaborated and worked with Andy on the Main Page backend (offered advice while he generated the code and software; also sent pieces of backend PHP code during Discord calls).
> - Last Modified: April 21, 2024 7:09 PM PST
