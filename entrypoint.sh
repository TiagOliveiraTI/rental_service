#!/bin/bash

# Turn on bash`s joob control
set -m

php-fpm &

nginx -g 'daemon off;'

fg %l