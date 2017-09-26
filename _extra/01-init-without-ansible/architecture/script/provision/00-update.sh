#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

echo "===[UPDATE]==="

rm -rf /etc/apt/apt.conf.d/10-smile-proxy.conf

apt-get update
apt-get -y install aptitude sudo curl vim

export DEBIAN_FRONTEND=noninteractive
aptitude -y safe-upgrade
export DEBIAN_FRONTEND=dialog

apt-get -y autoremove

echo ""
