FROM mcr.microsoft.com/devcontainers/php:3-8.5-trixie@sha256:8f7f26e7d2d8945d77e6e57b97ef1691ae5432195c92d6c45d30bf57295de424

ADD first-run-notice.txt /usr/local/etc/vscode-dev-containers/first-run-notice.txt

RUN apt-get update -y && \
    apt-get install -y libicu-dev inkscape && \
    docker-php-ext-install intl
