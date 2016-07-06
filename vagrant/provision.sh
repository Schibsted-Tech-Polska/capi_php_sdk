#!/usr/bin/env bash

VAGRANT_CONFIGURATION_DIR='/vagrant/vagrant/config'

. $VAGRANT_CONFIGURATION_DIR/setup.sh
. $VAGRANT_CONFIGURATION_DIR/php.sh

update_apt_packages && switch_to_vagrant_dir_automatically && install_php5
