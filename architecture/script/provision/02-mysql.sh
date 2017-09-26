#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[MYSQL]==="

echo "   => Prepare Root Pass"

ROOT_PASS=`date +%s | sha256sum | base64 | head -c 32 ; echo`

echo "   => Install package"

echo "deb http://repo.percona.com/apt jessie main" > /etc/apt/sources.list.d/percona.list

apt-key adv --keyserver keys.gnupg.net --recv-keys 8507EFA5

apt-get update
apt-get -y install python-mysqldb

export DEBIAN_FRONTEND=noninteractive
apt-get -y install percona-server-server
export DEBIAN_FRONTEND=dialog

mysqladmin -u root password ${ROOT_PASS}

echo "  => Configure"

systemctl stop mysql
systemctl status mysql
mkdir -p /etc/mysql/conf.d
mkdir -p /var/log/mysql
chown mysql.adm /var/log/mysql

rm -f /etc/mysql/conf.d/provision.cnf
cp -f /var/www/magento2/architecture/conf/mysql/provision.cnf /etc/mysql/conf.d/provision.cnf

echo "  => Clean"

rm -f /var/lib/mysql/ib*
rm -rf /var/lib/mysql/mysql/innodb_*
rm -rf /var/lib/mysql/mysql/slave_*

echo "  => Restart"

systemctl start mysql
systemctl is-enabled mysql || systemctl enable mysql
systemctl status mysql

echo "  => Automatic Root Pass"

touch /root/.my.cnf
chmod 600 /root/.my.cnf
echo "[client]"              >  /root/.my.cnf
echo "user=root"             >> /root/.my.cnf
echo "password=${ROOT_PASS}" >> /root/.my.cnf

echo ""
