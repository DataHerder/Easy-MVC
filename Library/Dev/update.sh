# !IMPORTANT!
# THIS FILE IS FOR UPDATING YOUR CONFIG FILES AND INDEX FILES
#
# RUN THIS FILE WHEN UPDATING THE LIBRARY TO KEEP UP TO DATE
# THIS FILE WILL CHANGE DYNAMICALLY WITH EACH PUSH TO GIT
# COPY OVER THE LIBRARY AND RUN THIS SCRIPT TO UPDATE YOUR SITE

BASEDIR=$(dirname $0)
APPCONGIF=0;
APPCONFIGCHANGE=1
APPCONFIG_NAME='config-app.php'
FORCEAPPCONFIG=0;
SKIPAPPCONFIG=0

if [ "$1" = '-skip-app' ]; then
	SKIPAPPCONFIG=1
elif [ "$1" = '-force-app' ]; then
	FORCEAPPCONGIF=1
fi

for item in "$@"
do

        if [ "$item" = "-skip-app" ]; then
                SKIPAPPCONFIG=1
        elif [ "$item" = "-force-app" ]; then
                FORCEAPPCONFIG=1
        else
                WHICH=""
        fi

done

if [ -f $BASEDIR/../../Application/config.php ]; then
	echo "Config exists"
	APPCONFIG=1
else
	echo "Not existing"
fi

if [ $APPCONFIGCHANGE = 1 ]; then
	if [ $APPCONFIG = 1 ] && [ $FORCEAPPCONFIG = 1]; then
		echo "Config file found in Application folder!\nWe are creating new config file as config-app-new.php\nYou can diff the files and see the changes."
		APPCONFIG_NAME='config-app-new.php'
	fi
fi

# update the root config file
cp -f $BASEDIR/config.php $BASEDIR/../../config.php

# skip the config file in /Application
if [ $SKIPAPPCONFIG = 1 ]; then
	echo "SKIPPING Application/config.php"
else
	# update the config-app file
	cp -f $BASEDIR/config-app.php $BASEDIR/../../$APPCONFIG_NAME
fi

#update the index file
cp -f $BASEDIR/index.php $BASEDIR/../../index.php

echo "DONE!"
