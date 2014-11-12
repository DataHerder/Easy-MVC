#API Directory / Handlers

###Your handler objects go here

Each request to the API is handled in the index.php file.  You extend the API Library and add custom
hooks within the _init method of your Api class.  More documentation will be added later,
the file itself, /Api/index.php has some examples.

Handlers are a way to organize your Api requests, so say you have this as your request

http://www.yourwebsite.com/Api/v1/feed-1.json

Your handler may be called Feed1 and the v1 is the version of the Api.  By extending the ApiHandler for your
Feed1 class, you have access to version control.