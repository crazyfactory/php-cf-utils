#!/bin/bash
if [ -n $TRAVIS_TAG ]
then
    printf "machine git.fury.io\nlogin $GEMFURY_USER\npassword $GEMFURY_PASSWORD" > ~/.netrc
    git remote add fury https://git.fury.io/crazyfactory/php-jobs.git
    git push --tags fury HEAD:master
else
    echo "No tag found"
fi