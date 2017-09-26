#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../

./script/provision/00-update.sh
./script/provision/01-basic.sh
./script/provision/02-mysql.sh
./script/provision/03-create-db.sh
./script/provision/04-redis.sh
./script/provision/05-nginx.sh
./script/provision/06-varnish.sh
./script/provision/07-apache.sh
./script/provision/08-php.sh

./script/permissions.sh

