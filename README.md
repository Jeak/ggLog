# ggLog

To Install, copy the neccesary scripts and html documents into a folder of your web server.  
Demo at [http://ko.kooia.info/ggLog/](http://ko.kooia.info/ggLog/)  
Concept video available at: [http://youtu.be/I5KrViMpEa4](http://youtu.be/I5KrViMpEa4)  
Many of the files are for storing IP addresses, requiring SQLite.  
Icons from Glyphicons, as integrated into Bootstrap 3.0 [http://glyphicons.com/](http://glyphicons.com/)  

## Contributors

* [Jack Gallegos](https://github.com/Jeak)
* [David Berard](https://github.com/davidberard98)
* [John Nover](https://www.facebook.com/john.nover.7)

## Current functions
* Add workouts
* Edit workouts
* Delete workouts
* Weekly Mileage

## Todo

* Re-design so it appears the same on all browsers
    + sometimes the words on buttons get cut off on some browsers
    + the save, cancel, delete buttons while editing sometimes roll over to a new line
    + Redo navbar
    + Redo "New Workout" button
    + Improve Weekly Mileage interface
* Routes (since a 10 mile glider port is easier than 10 mile PQ canyon)
    + PRs (also add PRs on distances)
    + Allow creation of routes
    + Auto-distances for routes using Javascript
* don't load everything at once - only show 30 or so workouts at a time
* Mobile version
* Add functionality for **users** (however, it would probably be better to get the demo working first before switching everything over to users)
* Set seasons with auto-adding mileage (Summer Training, Track season, Winter Training, Cross Country)
* Set goals (daily, weekly, season-ly, yearly)
* Coach account? (with the ability to view all & send out goals)
* Rankings between users (distance, speed, improvement)
    + Also with routes
* Specify races vs workouts
* PDF export / printing
* privacy settings
* Switch to PDO functions instead of sqlite\_exec and sqlite\_query
