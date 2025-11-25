# INSTALLATION GUIDE

## Requirements
- PHP latest version or alteast 8.2
- node.js latest
- composer 
- vscode 
- mysql (laragon, xampp, worbench, tableplus)
- Git latest 

## Steps
- After installing all requirements
- open terminal (cmd or powershell), type git clone "https://github.com/exequieltahop/abaka_classifier.git"
- after cloning, type cd abaka_classifier.
- type code .
- in vscode temrminal (crtl + j), type composer install.
- type npm install
- then copy the .env-example in root directory (same location as .env-example) then rename it into .env
- edit the database in the .env into your database
- in vscode terminal type php artisan key:generate
- type php artisan migrate:fresh --seed, note this is for the dummy users admin and expert
- type php artisan serve
- open a new terminal in vscode(crtl + shift + `) then type npm run dev, if error then open new terminal (new plus sign in bottom right in the terminal naay dropdown eclick, then click command prompt), then type again npm run dev
- good to go naaaaa.

