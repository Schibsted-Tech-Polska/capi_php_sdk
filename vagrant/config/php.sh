#!/usr/bin/env bash

function install_multiple_php_versions()
{
    apt-get install -y php5.5-cli php5.5-xml php5.5-mbstring php5.6-cli php5.6-xml php5.6-mbstring php7.0-cli php7.0-xml php7.0-mbstring
}

function install_composer_globally()
{
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
}
