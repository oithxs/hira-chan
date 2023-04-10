#!/bin/bash

screen -wipe

screen -dmS queue
screen -dmS build

screen -S queue -X stuff ' \
    cd "$WORKDIR"; \
    php artisan queue:work \
\n'

screen -S build -X stuff ' \
    cd "$WORKDIR"; \
    npm run watch \
\n'
