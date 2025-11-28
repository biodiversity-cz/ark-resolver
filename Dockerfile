FROM ghcr.io/biodiversity-cz/php-fpm-noroot-socket:main@sha256:62a884d4d0705e01a30cd081a051da6c89a07c94b2e14d4622a5f99e004202d2

MAINTAINER Petr Novotný <novotp@natur.cuni.cz>
LABEL org.opencontainers.image.source=https://github.com/biodiversity-cz/ark-resolver
LABEL org.opencontainers.image.description="ARK resolver fro biodiversity.cz"
ARG GIT_TAG
ENV GIT_TAG=$GIT_TAG

# devoted for Kubernetes, where the app has to be copied into final destination (/srv) after the container starts
COPY  --chown=www:www htdocs /app
RUN chmod -R 777 /app/temp

