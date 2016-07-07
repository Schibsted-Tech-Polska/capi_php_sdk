#!/usr/bin/env bash

function install_multiple_php_versions()
{
    apt-get install -y php5.5-cli php5.5-xml php5.6-cli php5.6-xml php7.0-cli php7.0-xml
}
