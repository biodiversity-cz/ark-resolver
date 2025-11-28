FROM ghcr.io/biodiversity-cz/php-fpm-noroot-socket:main@sha256:fba4b3a99b92a7b94ff235153edec3551f34d50882133fd960fe285cea1c12a3

MAINTAINER Petr Novotný <novotp@natur.cuni.cz>
LABEL org.opencontainers.image.source=https://github.com/biodiversity-cz/ark-resolver
LABEL org.opencontainers.image.description="ARK resolver fro biodiversity.cz"
ARG GIT_TAG
ENV GIT_TAG=$GIT_TAG

# devoted for Kubernetes, where the app has to be copied into final destination (/srv) after the container starts
COPY  --chown=www:www htdocs /app
RUN chmod -R 777 /app/temp

