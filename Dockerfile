FROM ghcr.io/biodiversity-cz/php-fpm-noroot-socket:main@sha256:374990e47a7e85e6817528ace6360ec24102d62c0d6dcab0ae9f5bd899debb03

MAINTAINER Petr Novotný <novotp@natur.cuni.cz>
LABEL org.opencontainers.image.source=https://github.com/biodiversity-cz/ark-resolver
LABEL org.opencontainers.image.description="ARK resolver fro biodiversity.cz"
ARG GIT_TAG
ENV GIT_TAG=$GIT_TAG

# devoted for Kubernetes, where the app has to be copied into final destination (/srv) after the container starts
COPY  --chown=www:www htdocs /app
RUN chmod -R 777 /app/temp

