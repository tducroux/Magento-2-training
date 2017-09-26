#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[REDIS]==="

echo "  => Install Package"
apt-get -y install redis-server

echo "  => Configure"
rm -f /etc/redis/redis_magento_cache.conf
rm -f /etc/redis/redis_magento_session.conf
rm -f /etc/systemd/system/redis-server@.service

cp -f /var/www/magento2/architecture/conf/redis/redis_magento_cache.conf   /etc/redis/redis_magento_cache.conf
cp -f /var/www/magento2/architecture/conf/redis/redis_magento_session.conf /etc/redis/redis_magento_session.conf
cp -f /var/www/magento2/architecture/conf/redis/redis-server@.service      /etc/systemd/system/redis-server@.service

echo "  => Disable Single Instance"
systemctl daemon-reload
systemctl stop redis-server
systemctl disable redis-server

echo "  => Enable Multi Instance"
systemctl daemon-reload
systemctl enable redis-server@magento_cache
systemctl enable redis-server@magento_session

echo "  => Start Multi Instance"
systemctl daemon-reload
systemctl start  redis-server@magento_cache
systemctl start  redis-server@magento_session

echo "  => Status Multi Instance"
systemctl status redis-server@magento_cache
systemctl status redis-server@magento_session

echo ""
