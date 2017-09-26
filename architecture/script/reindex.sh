#!/usr/bin/env bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
cd ../../

sudo -u www-data bin/magento indexer:reindex
sudo -u www-data bin/magento cache:clean