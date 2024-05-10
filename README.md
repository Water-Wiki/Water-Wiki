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

2. Locate "Databases" in the clone folder and add the inside contents to the following below:
> xampp > MySQL > data

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

3. Rename the folder you cloned to
> htdocs

4. Delete "htdocs" folder inside the "xampp" folder and replace it with the cloned "htdocs" folder
5. Type localhost using any browser and begin the program inside Main.php.

## And you should be all set!

## Adding dummy data
1. Run dummyData.sql in MySQL after creating the databases needed to hold the data
> The script creates
>> 50 users in sequence
>> 50 badges randomly assigned to users
>> 200 pages randomly assigned to categories with Lorem ipsum text
>> 50 forum posts assigned to random users with Lorem ipsum text
>> 250 comments randomly assigned to users and pages with Lorem ipsum text
>> 100 comments randomly assigned to users and forums with Lorem ipsum text
>> 150 likes randomly assigned to users and comments
>> 100 dislikes randomly assigned to users and comments
>> 50 stars randomly assigned to users and receivers

#### Contributers
>
> - Andy Nguyen
> - William Tran
> - Zach Bernales
> - Ravi G
> - Zach Hobbs
> - Last Modified: April 21, 2024 7:09 PM PST
