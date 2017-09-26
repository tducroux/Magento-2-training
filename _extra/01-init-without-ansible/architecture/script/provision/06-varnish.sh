#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[VARNISH]==="

echo "  => Install Package"

curl https://repo.varnish-cache.org/GPG-key.txt | apt-key add -
echo "deb https://repo.varnish-cache.org/debian/ jessie varnish-4.1" > /etc/apt/sources.list.d/varnish.list

apt-get update
apt-get -y install varnish
varnishd -V

echo "  => Configure"

rm -f /etc/default/varnish
rm -f /etc/varnish/magento2.vcl
rm -f /etc/systemd/system/varnish.service
rm -f /etc/systemd/system/varnishncsa.service

cp -f /var/www/magento2/architecture/conf/varnish/default             /etc/default/varnish
cp -f /var/www/magento2/architecture/conf/varnish/magento2.vcl        /etc/varnish/magento2.vcl
cp -f /var/www/magento2/architecture/conf/varnish/varnish.service     /etc/systemd/system/varnish.service
cp -f /var/www/magento2/architecture/conf/varnish/varnishncsa.service /etc/systemd/system/varnishncsa.service

echo "  => Services Enabled"
systemctl daemon-reload
systemctl is-enabled varnish || sudo systemctl enable varnish
systemctl is-enabled varnishncsa || sudo systemctl enable varnishncsa

echo "  => Services Restart"
systemctl daemon-reload
systemctl restart varnish
systemctl restart varnishncsa

echo "  => Services Status"
systemctl status varnish
systemctl status varnishncsa

echo ""
