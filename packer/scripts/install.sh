#!/bin/bash

# Name: install.sh
# Description: Install the results site.

mv /tmp/results /var/www/results
cd /var/www/results && bin/phing build
chown -R www-data:www-data /var/www/results

