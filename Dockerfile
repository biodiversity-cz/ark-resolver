FROM ghcr.io/biodiversity-cz/php-fpm-noroot-socket:main@sha256:4f2e5273374a53ed603c2bd4eefb7a547b19913ab5e67068dd9906a4905f9257

MAINTAINER Petr Novotný <novotp@natur.cuni.cz>
LABEL org.opencontainers.image.source=https://github.com/biodiversity-cz/ark-resolver
LABEL org.opencontainers.image.description="ARK resolver fro biodiversity.cz"
ARG GIT_TAG
ENV GIT_TAG=$GIT_TAG

# devoted for Kubernetes, where the app has to be copied into final destination (/srv) after the container starts
COPY  --chown=www:www htdocs /app
RUN chmod -R 777 /app/temp

