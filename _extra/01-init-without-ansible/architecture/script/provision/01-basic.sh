#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[BASIC]==="

apt-get -y install ca-certificates
apt-get -y install bash-completion
apt-get -y install file
apt-get -y install lsof
apt-get -y install moreutils
apt-get -y install patch
apt-get -y install rsync
apt-get -y install ssh
apt-get -y install ssl-cert
apt-get -y install strace
apt-get -y install tcpdump
apt-get -y install telnet
apt-get -y install unzip
apt-get -y install curl
apt-get -y install ntp
apt-get -y install iotop
apt-get -y install apt-transport-https
apt-get -y install tar
apt-get -y install wget

echo "" >> /etc/hosts
echo "# Magento Aliases"  >> /etc/hosts
echo "127.0.0.7 myfront1" >> /etc/hosts
echo "127.0.0.7 myredis"  >> /etc/hosts
echo "127.0.0.7 mydb"     >> /etc/hosts

echo ""
