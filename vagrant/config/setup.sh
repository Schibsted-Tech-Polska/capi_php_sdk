#!/usr/bin/env bash

function update_and_install_apt_packages()
{
    add-apt-repository -y ppa:ondrej/php && apt-get update
    apt-get install -y git
}

function switch_to_vagrant_dir_automatically()
{
    echo 'cd /vagrant' > /home/vagrant/.bashrc
}
