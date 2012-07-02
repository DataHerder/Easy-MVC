Easy-MVC
========

A fast lightweight MVC framework
--------------------------------

###Quick Introduction

Really simple to get up and running.  Requires access to the command line.

- 1. Download from repo to a working web directory.
- 2. Navigate to the repo on the command line.
- 3. cmd: touch .ready
- 4. cmd: ./makefile.sh
- 5. Take notice that directory "web-root" now exists.
- 6. Point your localhost to that spot on your server.
     eg: localhost/root/to/easy-mvc/web-root
- 7. cp or mv web-root to any directory or name you wish.
     All the files in web-root are a working site.  The repo
     only exists to continue making sites with ./makefile.sh

###Updating Production copy

Do the same thing as mentioned above.  However the only difference is
that you simply have to copy over the library.  That's it.

###What does ./makefile.sh do?

It just makes a working site for you using the library.  It sets
up the working directories and the site structure, puts a welcome
page in there and situates files.