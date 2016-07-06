#!/usr/bin/env bash

function update_apt_packages()
{
    apt-get update
}

function switch_to_vagrant_dir_automatically()
{
    echo 'cd /vagrant' > /home/vagrant/.bashrc
}
