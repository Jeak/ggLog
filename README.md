# ggLog

To Install, copy the neccesary scripts and html documents into a folder of your web server.  
Demo at [http://ko.kooia.info/ggLog/](http://ko.kooia.info/ggLog/)  
Concept video available at: [http://youtu.be/I5KrViMpEa4](http://youtu.be/I5KrViMpEa4)  
Many of the files are for storing IP addresses, requiring SQLite.  
Icons from Glyphicons, as integrated into Bootstrap 3.0 [http://glyphicons.com/](http://glyphicons.com/)  
Charts: Used Flotcharts

## Contributors

* [Jack Gallegos](https://github.com/Jeak)
* [David Berard](https://github.com/davidberard98)
* [John Nover](http://gglog.xyz/special.php)

## Misc. Notes

* There's some REALLY weird things to do with .htaccess files in order to rewrite "astext.__php__" as "astext.__txt__".  Config will need to address that; it's currently just optimized for our current location.

When using, create a __config.php__ file which includes this:

```php
define("GG_HOST", "your mysql host");
define("GG_DATABASE", "your mysql database");
define("GG_TABLE", "your mysql table containing workouts");
define("GG_SEASONS", "your mysql table containing season info");
define("GG_PREFIX", "gg_ (or similar)");
define("GG_USERNAME", "username to your mysql database");
define("GG_PASSWORD", "password to your mysql database");

function gg_get_pdo()
{
  return new PDO("mysql:host=" . GG_HOST . ";dbname=" . GG_DATABASE, GG_USERNAME, GG_PASSWORD );
}
```

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
* Incomplete Ajax loading

## Todo + Ideas

Bold indicates that an item is being worked on.

* Emoticons
* __NEED TO WORK ON: Finish flotrackr upload & parse__
* __Safe, secure, multi-user system!!__
* Auto-add total mileage
* __Set seasons with auto-adding mileage (Summer Training, Track season, Winter Training, Cross Country)__ __dev__
    + UI for editing seasons
    + Perhaps a larger interface for editing
    + JS shorten title so it won't overflow in the list
* __Modularize (so you don't have a single 25kb php file containing all html, css, php, javascript, sql, etc)__
* Weekly Mileage
    + Sort by distance, time, avg. pace, date, etc.
    + something like [this](http://bl.ocks.org/mbostock/4063318) for displaying mileage per day
    + bar charts for miles run on mon, tues, wed, etc.
    + charts for miles etc.  Include seasons in it?
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
* Option to hide notes
* Routes (since a 10 mile glider port is easier than 10 mile PQ canyon)
    + redo SQLite database to allow routes to be associated with runs
    + new SQLite database storing routes
    + Sharing routes between users
    + PRs (also add PRs on distances)
    + Allow creation of routes
    + Auto-distances for routes using Javascript
* don't load everything at once - only show 30 or so workouts at a time ??
    + revamp to have ajax - and autoscroll stuff, so you don't have to press the button every time
* Use JQuery instead of javascript?
* Prevent re-submitting when reloading the page?
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
* __Download / export__
    + __basic .txt doc__
    + PDF export / printing
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
* miles/km, lbs/kg
* MySQL version
* No stray escape characters when editing a post with quotation marks.

#### Parts of the user system
* Login screen
* Navbar changes depending on whether you're logged in
* Profile pictures:
  + Limit who can see profile pictures: probably with some php linked with .htaccess
* Hash/password and all that great stuff
* User permissions
* User friends, and who can see who's activity
* Settings for your account (who can see what, your profile picture)
* Which groups you're in.
* We can either store this all in the &#95;seasons or whatever table, or in the big user-table.
