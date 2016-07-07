#!/usr/bin/env bash

VAGRANT_CONFIGURATION_DIR='/vagrant/vagrant/config'

. $VAGRANT_CONFIGURATION_DIR/setup.sh
. $VAGRANT_CONFIGURATION_DIR/php.sh

update_and_install_apt_packages &&
switch_to_vagrant_dir_automatically &&
install_multiple_php_versions &&
install_composer_globally
