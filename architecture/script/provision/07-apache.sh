#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[APACHE]==="

echo "  => Install Packages"

apt-get -y install apache2
apt-get -y install apache2-mpm-event
apache2 -v

echo "  => Configure"

rm -f /etc/apache2/ports.conf
rm -f /etc/apache2/sites-enabled/*
rm -f /etc/apache2/mods-available/remoteip.conf

ln -s /var/www/magento2/architecture/conf/apache/ports.conf    /etc/apache2/ports.conf
ln -s /var/www/magento2/architecture/conf/apache/magento2.conf /etc/apache2/sites-enabled/magento2.conf
ln -s /var/www/magento2/architecture/conf/apache/remoteip.conf /etc/apache2/mods-available/remoteip.conf

echo "  => Enable Modules"

a2enmod deflate
a2enmod expires
a2enmod headers
a2enmod proxy_fcgi
a2enmod remoteip
a2enmod rewrite

echo "  => Test Conf"

apache2ctl -S

echo "  => Service Restart"

systemctl daemon-reload
systemctl restart apache2

echo "  => Service Status"

systemctl status apache2

echo ""

