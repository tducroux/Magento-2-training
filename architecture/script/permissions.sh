#!/usr/bin/env bash

echo ""
echo "Update Permissions"
echo ""

chown -R smile.www-data /var/www/magento2/app/etc
chmod -R 664 /var/www/magento2/app/etc
chmod -R +X /var/www/magento2/app/etc

chown -R smile.www-data /var/www/magento2/pub/static
chmod -R 664 /var/www/magento2/pub/static
chmod -R +X /var/www/magento2/pub/static

chown -R smile.www-data /var/www/magento2/pub/media
chmod -R 664 /var/www/magento2/pub/media
chmod -R +X /var/www/magento2/pub/media

chown -R smile.www-data /var/www/magento2/var
chmod -R 664 /var/www/magento2/var
chmod -R +X /var/www/magento2/var

chmod +x /var/www/magento2/bin/*

echo ""
echo "  => Finish"
echo ""