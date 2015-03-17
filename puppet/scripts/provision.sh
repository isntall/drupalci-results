#!/bin/bash

# Name:        provision.sh
# Description: Install the base packages.
# Author:      Nick Schuch

DIR=`pwd`

# Helper function to install packages.
aptInstall() {
  COUNT=$(dpkg --get-selections $1 | grep -v deinstall | wc -l)
  if [ "$COUNT" -eq "0" ]; then
    apt-get -y install $1
  fi
}

# Helper function to install gems packages.
gemInstall() {
  COUNT=`gem list | grep $1 | wc -l`
  if [ "$COUNT" -eq "0" ]; then
    gem install $1
  fi
}

# Install the required packages.
sudo sed -i "/^# deb.*multiverse/ s/^# //" /etc/apt/sources.list
apt-get update && apt-get -y upgrade && apt-get -y dist-upgrade
aptInstall curl
aptInstall make
aptInstall build-essential
aptInstall wget
aptInstall git
aptInstall ruby1.9.1-dev
aptInstall vim
gemInstall bundler
apt-get clean && apt-get -y autoremove

# Install the required packages and provision.
cd $DIR && bundle install --path vendor/bundle
cd $DIR && bundle exec librarian-puppet install
cd $DIR && sudo -E bundle exec puppet apply --modulepath $DIR/modules --hiera_config=$DIR/etc/hiera.yaml $DIR/site.pp
