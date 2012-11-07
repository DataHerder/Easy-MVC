#!/bin/bash

# the root directory where the architecture is found
ROOT="/Applications/XAMPP/xamppfiles/htdocs/toolkit/PHP/MyEasyMVC/"

# this shell scripts bundles the latest working development
# into the github repository

if [ -z "$1" ]; then
	echo no arguments
	exit
fi


# setup the development variable to copy files from
PRO="$ROOT"Production/
if [ "$1" = "-h" ]; then
	#inspect this
	DEV="../"
elif [ "$1" = "-d" ]; then
	DEV="$ROOT"Development/
else
	echo invalid argument
	exit
fi


# remove the Productions folder
echo "Bundling MyEasyMVC"
rm -rf $PRO
mkdir $PRO
mkdir "$PRO"Library


# start copying the files over
# copy major folders over first
#mkdir "$PRO"Library/Controllers
cp -rf "$DEV"Controllers "$PRO"Library/Controllers
cp -rf "$DEV"Framework "$PRO"Library/Framework
cp -rf "$DEV"Helpers "$PRO"Library/Helpers
cp -rf "$DEV"Models "$PRO"Library/Models
cp -rf "$DEV"Routers "$PRO"Library/Routers
cp -rf "$DEV"Views "$PRO"Library/Views

cp "$DEV"bootstrap.php "$PRO"Library/bootstrap.php
cp "$DEV"Dev/package.json "$PRO"package.json
cp "$DEV"Dev/LICENSE "$PRO"LICENSE
cp "$DEV"Dev/makefile.sh "$PRO"makefile.sh
cp "$DEV"Dev/README.md "$PRO"README.md

# copy dev folder
cp -rf "$DEV"Dev/ "$PRO"Library/Dev/

# setup for testing
rm -rf "$ROOT"Test/
cp -rf "$PRO" "$ROOT"Test/

# make the site
chmod +x "$ROOT"Test/makefile.sh
chmod +x "$ROOT"Test/Library/Dev/clean-sweep.sh
# make the file for makefile to run
touch "$ROOT"Test/.ready
echo "This repo is ready to be made" > "$ROOT"Test/.ready
#"$ROOT"Test/makefile.sh -r $ROOT/Test
# now setup the test environment
echo "DONE!"

# PRODUCTION HAS THIS LAYOUT
# BUNDLED on github root files and all directories
#  - ROOT
#   - Library
#    - *Controllers
#    - *Docs
#      - .htaccess       *move to root folder
#      - index.php       *move to root folder
#      - compileless.sh  *move to media folder when created
#    - *Framework
#    - *Helpers
#    - *Models
#    - *Routers
#    - *Views
#    - bootstrap.php
#    - package.json
#    - Makefile
#    - LICENCE
#    - README.md

