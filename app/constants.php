<?php

define("DBNAME", "dipl");
define("USERNAME", "root");
define("PASS", "");
define("SREGEXPRULES","/^[A-Za-z0-9_~\-!@#\$%\^. `\\\,<>=+{}\[\]|?:\"'\/&*\(\)]+$/"); // a to z, A to Z, 0 - 9, _ - ~ ! @ # $% ^ & * () allowed special characters. Allowing only normal needed characters */
define("LREGEXPRULES",'/.*/s'); // Allowing everything (greek chars, more special chars, etc)
define("TREGEXPRULES",'/^[a-z0-9][a-z0-9 ]*$/i'); // Reg Exp for titles, allowing only letters and numbers (we use it in URL)
define("ADMINEMAIL", "admin@gmail.com");
define("ADMINPASS", "123");
/*

DOCUMENTATION OF DATABASE SCHEMA

REVIEWS table  = |id|, |title|, |content|, |date|, |imageName|, |author|, |authorId|, |rating|, |category|, |aproved|
ARTICLES table = |id|, |title|, |content|, |date|, |imageName|, |author|, |authorId|, |category|, |aproved|
USERS table    = |id|, |name|, |email|, |password|, |salt|

Users Registered:
mallibu97@gmail.com , Chris Maroudas, 123
ggoria@gmail.com, Grigoria Pontiki, 123

Admin:
admin@gmail.com
123

TOOLS USED:
PHPStorm / Sublime Text 2/ PhpMyAdmin/ Foundation CSS framework/ PHP Error Library / RubyGEM SASS/ Terminal / WAMP / Typekit / Photoshop / jQuery / HTML5 boilerplate / Modernizr / Chrome Debugging Tools / DISQUS

TECH USED:
PHP 5.4, MySQL, HTML5, CSS3, Ruby, Javascript/jQuery, SASS, Ruby GEMS


============= VERSIONS =============

*** 0.1 ***

[ BACK END ]

- Routing with object Router & and Reg Exp through .htaccess using mod_rewrite.
- Classes Model / View / Controller initilization through the constructor, and controller in app.php
- Basic functionality
- Front page template

----------------------------

*** 0.15 ***

[ BACK END ]

- Log in, Sign Up, Review specific
- Added PDOs along with exceptions
- Hash sha256 (to be changed with bcrypt).

----------------------------

*** 0.2 ***

[ BACK END ]

- Implementing bcrypt for password hashing
- log in functionality done in controller & model
- Session initilization
- Abstraction method for $_POST variables
- Log out
- Router 404.html redirect
- Fixed the model insert query, with a separate var for limit, so every query can have limits.
- Refactored the insert & select query
- Fixed the model self tests for PDO, and corrected logic.
- Refactored self tests

----------------------------

*** 0.25 ***

[ BACK END ]

- Implemented a session destroy when the user is logged in above 2 hours, in the constructor.
- Polished regular expressions to two (2) CONSTANTS, the loose regular expression one (accepting all characters) and the strict regular expression (acceptin certain strict entities)
- POST abstraction method defaults to the LOOSE REG EXP rules
- Included trim in the POST abstraction method, so we avoid repeat it all the time.
- Changed the signUp method to include abstraction POST method
- Implemented sticky form in sign up
- Implemented different error messages in sign up, what field was given wrong.
- Refactored the single extract $data to not bug, by using reset(); . reset(); returns the first element of an array

----------------------------

*** 0.3 ***

[ BACK END ]

- Changed the Log In to include the new getPostRequest method
- Changed the Log In to show separate error messages and display them in the template
- Changed the Log In to redirect to My Profile page when the users clicks on Log In and it's already Logged in
- Implemented the new My Profile page, and added it to the router
- Implemented the categories page and added it to the router
- Completed full categories page, one for general categories, and one for showing reviews in a specific category

----------------------------

*** 0.35 ***

[ BACK END ]

- Added admin panel page
- Added approved field to database.
- Implemented the UPDATE and REMOVE methods to the model.
- Implemented the adminPanel() function and the logic behind it
- Refactored the loadView() function to repeatedly require views when we pass a 2 dimensional array (multiple reviews)
- Now are views can be more consistent, and not do a loop inside them
- Implemented the /delete/$id  &  /approve/$id links

----------------------------

*** 0.4 ***

[ BACK END ]

- Implemented the edit link in the admin panel views
- Implemented the edit form and made it work

----------------------------

*** 0.45 ***

 [ BACK END ]

- Implemented the postNewReview page
- Sticky forms for that page along with improved error handling
- Implemented logical checks requiring logged in users to submit their reviews, else redirecting to /login
- Refactored AGAIN the loadView so it has better logic to recognizing the arrays the $data contains
- Implemented STR_REPLACE function in views that display $content, to keep the original line breaks
- Replaced the <br /> with </p> <p> for SEO reasons!
- Used substract(); in pages showing multiple reviews
- Added AuthorId to DB Schema. Reviews needed a foreign key from the users table

[ FRONT END]

- Basic typography, and fonts selection
- Background image

----------------------------

*** 0.5 ***

 [ BACK END ]

- Implemented a new TREGEXPRULES (Title Regular Expression Rules) specifically for titles, and allowing only letters and numbers
- Tweaked some things a bit
- Rewrote all DB entries so it has some normal data inside it
- DISQUSS commenting system integration!

 [ FRONT END ]

- Various review appearance tweaks
- Made the user control panel appear


----------------------------

*** 0.55 ***

 [ BACK END ]

- Made categories Generic page
- Made about us page
- Made search page
- Implemented the searchReview method in the controller
- Implemented the search method in Model
- Implemented the about function in Controller

----------------------------

*** 0.6 ***

 [ BACK END ]

- Articles implemented in Controller & Model
- getSliderData() method in Model
- Slider gets fed with the latest 3 articles
- Post new, now has option to post article or review
- Fixed the controller to properly insert reviews or articles to the appropriate table

 [FRONT END]

- Slider implemented

----------------------------

*** 0.65 ***

 [ BACK END ]

- Articles & reviews pages, refactored to better recognise what is requested.
- Articles & reviews now can display specific categories when requested in the url (triggered by the menu submenus)
- Articles & reviews, display the specific article when a title is given instead of 'category' in the url
- Various refactorings

 [ FRONT END ]

- Implemented submenus in articles / reviews


----------------------------

*** 0.7 ***

 [ BACK END ]

- Refactored the entire administrator controller method, to implement both articles and reviews edits, according to the url given
- Corrected all the views associated to represent the corresponding data


----------------------------

*** 0.75 ***

 [ BACK END ]

- Implemented sidebar
- SidebarData method in Model implemented
- getSidebarData method in Controller implemented
- Working sidebar
- Lot's of various bug fixes


----------------------------

*** 0.8 ***

 [ BACK END ]

- Changed articles categories to: Technology, Tuning, Other
- URL encoded article names and URL decoded in controller










===============================================================================

TOTAL PAGES
*	DONE
Front page, Specific Review, Sign Up, Log In, logout, Categories Single & All, Admin panel, Post new, search, my profile

*   INCOMPLETE



General things to be done :

- Icon fonts
- Sidebar Facebook group
- Fix each form for article/review to have category radio button, and eliminate rating field in articles

*/