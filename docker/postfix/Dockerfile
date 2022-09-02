FROM ubuntu:20.04

RUN apt-get update \
    && apt-get install -y \
        bsd-mailx \
        libsasl2-modules \
    && DEBIAN_FRONTEND=noninteractive apt-get install postfix -y

COPY main.cf /etc/postfix/main.cf
