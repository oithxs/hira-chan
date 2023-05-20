FROM ubuntu:22.04

WORKDIR /work

COPY --from=node:18.16.0-slim /usr/local /usr/local

RUN npm i -g laravel-echo-server

CMD ["laravel-echo-server", "start", "--force"]
