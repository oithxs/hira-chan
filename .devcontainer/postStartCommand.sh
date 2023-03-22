#!/bin/bash

cd /usr/src/app

php artisan queue:work
