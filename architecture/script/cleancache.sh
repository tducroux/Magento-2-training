#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

sudo -u www-data bin/magento cache:clean
sudo -u www-data rm -rf var/di/*
sudo -u www-data rm -rf var/generation/*
