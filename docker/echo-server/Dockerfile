FROM ubuntu:22.04

WORKDIR /work
ENV LANG="C.UTF-8"
ENV TZ="Asia/Tokyo"

COPY --from=node:18.16.0-slim /usr/local /usr/local

COPY ./docker/echo-server/laravel-echo-server.json /work/laravel-echo-server.json

RUN npm i -g laravel-echo-server

CMD ["laravel-echo-server", "start", "--force"]
