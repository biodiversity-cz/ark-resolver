FROM ghcr.io/biodiversity-cz/php-fpm-noroot-socket:main@sha256:4a2746d7d43951dd57d28e85cc58e3848932d7602eab8e6359a1f246e263539d

MAINTAINER Petr Novotný <novotp@natur.cuni.cz>
LABEL org.opencontainers.image.source=https://github.com/biodiversity-cz/ark-resolver
LABEL org.opencontainers.image.description="ARK resolver fro biodiversity.cz"
ARG GIT_TAG
ENV GIT_TAG=$GIT_TAG

# devoted for Kubernetes, where the app has to be copied into final destination (/srv) after the container starts
COPY  --chown=www:www htdocs /app
RUN chmod -R 777 /app/temp

