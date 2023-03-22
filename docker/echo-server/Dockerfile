FROM debian:bullseye-slim

WORKDIR /work

COPY --from=node:16.18.0-slim /usr/local /usr/local

RUN npm i -g laravel-echo-server

CMD ["laravel-echo-server", "start"]
