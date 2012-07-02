# variables
HR="############################"
ROOT=""
ROOT_HIT=0
DEV=0
WHICH=""
# you can change this if desired
WEBROOT="web-root"


# first check if the appropriate file exist
# this keeps us from running in development mode
if [ -f  .ready ]; then
	echo Starting Build
else
	echo "ERROR: Not a fresh bundle or git repo.\
  Please fetch from git or access this file from a bundle."
	exit
fi



for item in "$@"
do

	if [ "$WHICH" = "root" ]; then
		ROOT="$item"
	fi

	if [ "$item" = "-r" ]; then
		WHICH="root"
		ROOT="HIT_ROOT"
	elif [ "$item" = "-d" ]; then
		DEV=1
	else
		WHICH=""
	fi

done

if [ "$ROOT" = "HIT_ROOT" ]; then
	echo 'Sorry bro.  You have to specify a root directory with -r';
	exit;
fi

if [ "$ROOT" != "" ]; then
	if [ ! -d "$ROOT" ]; then
		echo 'Broski!  Root directory provided does not exist!'
		exit;
	fi
	ROOT=$(echo "$ROOT" | sed 's/\/*$//')
	ROOT=$ROOT/
fi


if [ "$DEV" = "1" ]; then
	#we want to change the webroot to Development
	WEBROOT="Development"
fi


echo "Production Started"
# this builds the files in the necessary directory
# first create the directories needed currently this make is included in the root directory after running "bundle.js"
echo "Making MVC Parent Folders"

# remove folder if exist
rm -rf $WEBROOT
mkdir $WEBROOT

# Second Make the necessary folders in Site copy over the library
mkdir $WEBROOT/Library

# make the Site Architecture
echo "Building Site Architecture"
mkdir "$ROOT"$WEBROOT/Application
mkdir "$ROOT"$WEBROOT/Application/Controllers
mkdir "$ROOT"$WEBROOT/Application/Models
mkdir "$ROOT"$WEBROOT/Application/Views
mkdir "$ROOT"$WEBROOT/Application/Modules

#creating parent media file
echo "Building Media Folders"
mkdir "$ROOT"$WEBROOT/Media
mkdir "$ROOT"$WEBROOT/Media/css
touch "$ROOT"$WEBROOT/Media/css/main.css
mkdir "$ROOT"$WEBROOT/Media/css/less
touch "$ROOT"$WEBROOT/Media/css/less/main.less
mkdir "$ROOT"$WEBROOT/Media/css/compiled
mkdir "$ROOT"$WEBROOT/Media/css/resources
mkdir "$ROOT"$WEBROOT/Media/img

cp -rf "$ROOT"Library/Controllers "$ROOT"$WEBROOT/Library/Controllers
cp -rf "$ROOT"Library/Framework "$ROOT"$WEBROOT/Library/Framework
cp -rf "$ROOT"Library/Helpers   "$ROOT"$WEBROOT/Library/Helpers
cp -rf "$ROOT"Library/Models    "$ROOT"$WEBROOT/Library/Models
cp -rf "$ROOT"Library/Routers   "$ROOT"$WEBROOT/Library/Routers
cp -rf "$ROOT"Library/Views     "$ROOT"$WEBROOT/Library/Views

# make API directory
mkdir "$ROOT"$WEBROOT/Api

#copy files to the root directory them over, don't over write if already exists
cp "$ROOT"Library/Dev/.htaccess  "$ROOT"$WEBROOT/.htaccess
cp "$ROOT"Library/Dev/index.php  "$ROOT"$WEBROOT/index.php
cp "$ROOT"Library/Dev/config.php "$ROOT"$WEBROOT/config.php
cp "$ROOT"Library/Bootstrap.php   "$ROOT"$WEBROOT/Library/Bootstrap.php

# make the docs page
mkdir "$ROOT"$WEBROOT/Docs

# move the welcome page
cp "$ROOT"Library/Dev/landing/Landing.php "$ROOT"$WEBROOT/Application/Controllers/
mkdir "$ROOT"$WEBROOT/Application/Views/Landings
cp "$ROOT"Library/Dev/landing/welcome.php "$ROOT"$WEBROOT/Application/Views/Landings/



if [ "$DEV" != "" ]; then
	# populate the Dev Root
	cp -rf "$ROOT"Library/Dev "$ROOT"$WEBROOT/Library/Dev
fi





###############################################
#
#  NOTES
#
###############################################
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

# Makefile Should create this file directory listing
# ROOT
#  - .htaccess
#  - index.php

#  - Application
#    - Controllers
#    - Models
#    - Modules
#    - Views

#  - Library
#    - Controllers
#    - Docs
#      - Makefile  * move makefile to this directory
#                  * move the rest of the files to the directory
#    - Models
#    - Modules
#    - Views

#  - Media
#    - css
#      - main.css
#      - less
#        - main.less
#      - compiled
#      - compileless.sh
#    - img
#    - js
