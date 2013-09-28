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
* <span style="color:#F33;">Seasons</span> (incomplete)
    + Order by week
    + SQLite database/table for seasons
    + Remove seasons
    + Seasons are week-based!
    + auto add mileage

## Todo + Ideas

* __Auto-add total mileage__
* __Set seasons with auto-adding mileage (Summer Training, Track season, Winter Training, Cross Country)__ __dev__
    + UI for editing seasons 
    + Perhaps a larger interface for editing
    + JS shorten title so it won't overflow in the list
* __Modularize (so you don't have a single 25kb php file containing all html, css, php, javascript, sql, etc)__
* Weekly Mileage
    + Sort by distance, time, avg. pace, date, etc.
* Daily Mileage
    + Group workouts that happen on the same day, so you can input your 3 mile tempo seperately from the 5 miles of easy running.
* Date auto-fill:
    + Allow future dates, or allow inputting dates.
    + Calendars?
* Mobile version / Redesign to appear the same on all browsers
    + boostrap seems to change based on your browser
    + sometimes the words on buttons get cut off on some browsers
    + the save, cancel, delete buttons while editing sometimes roll over to a new line [ iphone ]
    + fluid layout (w. percentages) ?
    + Redo navbar
    + Redo "New Workout" button
    + Improve Weekly Mileage interface
* Routes (since a 10 mile glider port is easier than 10 mile PQ canyon)
    + redo SQLite database to allow routes to be associated with runs
    + new SQLite database storing routes
    + Sharing routes between users
    + PRs (also add PRs on distances)
    + Allow creation of routes
    + Auto-distances for routes using Javascript
* don't load everything at once - only show 30 or so workouts at a time ??
    + revamp to have ajax
* Use JQuery instead of javascript?
* Add functionality for **users** (however, it would probably be better to get the demo working first before switching everything over to users)
* Set goals (daily, weekly, season-ly, yearly)
    + update primary SQLite database to include a location for goals
    + distance goal
    + time goal
    + goal notes
* Coach account?
    + can view all student accounts
    + students can type in code to become a coach's student
    + can send out goals
* Rankings between users (distance, speed, improvement)
    + Also with routes
* Specify races vs workouts
    + addtl. column in primary SQLite table for type of run
    + editable run types
    + preset run types
* PDF export / printing
    + in js or php or perl
* privacy settings
* Switch to PDO functions instead of sqlite\_exec and sqlite\_query
* Perhaps some kind of auto-loading weather
* Set location
* Set weight
    + calculate calories burned (0.8 &#42; lbs &#42; miles)
* Configure page
* Remember date that workout was submitted
* Holidays?
* Color coding mileages
* MySQL version
