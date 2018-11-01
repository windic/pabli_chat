#!/bin/sh
# Syncs (with rsync) the source and destination directories

#user
USER=pi
#Name of the project
PROJECT=pabli_chat

# Destination directory
DEST_DIR=/var/www/html/$PROJECT
# Source directory
SRC_DIR=/home/$USER/$PROJECT


# Exclude directory
EXCLUDE_DIR=fuelphp/fuel/app/logs
EXCLUDE_DIR2=fuelphp/fuel/app/uploads


# Do the actual sync
sudo rsync -avz --chmod g+rX --delete $SRC_DIR $DEST_DIR
