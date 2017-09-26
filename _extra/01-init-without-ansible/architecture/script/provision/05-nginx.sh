#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[NGINX]==="

echo "  => Install Package"

apt-get -y install nginx

echo "  => Configure"

rm -f /etc/nginx/sites-enabled/*
ln -s /var/www/magento2/architecture/conf/nginx/magento2-ssl /etc/nginx/sites-enabled/magento2-ssl

echo "  => Prepare Service"

systemctl daemon-reload
systemctl is-enabled nginx || sudo systemctl enable nginx
systemctl restart nginx
systemctl status nginx

echo ""
