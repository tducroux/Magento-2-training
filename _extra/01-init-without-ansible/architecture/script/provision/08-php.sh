#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[PHP-FPM]==="


echo "  => Install Packages"

apt-get install -y php5-fpm
apt-get install -y php5-curl
apt-get install -y php5-gd
apt-get install -y php5-intl
apt-get install -y php5-mcrypt
apt-get install -y php5-mhash
apt-get install -y php5-mysql
apt-get install -y php5-readline
apt-get install -y php5-redis
apt-get install -y php5-xsl

php -v

echo "  => Configure"

rm -f /etc/php5/fpm/conf.d/80-provision.ini
rm -f /etc/php5/cli/conf.d/80-provision.ini
rm -f /etc/php5/fpm/pool.d/*

ln -s /var/www/magento2/architecture/conf/php/magento2.fpm.ini   /etc/php5/fpm/conf.d/80-provision.ini
ln -s /var/www/magento2/architecture/conf/php/magento2.cli.ini   /etc/php5/cli/conf.d/80-provision.ini
ln -s /var/www/magento2/architecture/conf/php/magento2.pool.conf /etc/php5/fpm/pool.d/magento2.conf

echo "  => Service Enable"
systemctl daemon-reload
systemctl is-enabled php5-fpm || sudo systemctl enable php5-fpm

echo "  => Service Restart"
systemctl daemon-reload
systemctl restart php5-fpm

echo "  => Service Status"
systemctl status php5-fpm

echo ""
