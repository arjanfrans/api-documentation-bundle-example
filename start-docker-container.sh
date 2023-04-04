#!/bin/bash -e

cp -n .env.dist .env
source .env

container=symfony

docker build \
  --build-arg PHP_VERSION=${PHP_VERSION} \
  --build-arg PHP_DOCKER_RELEASE=${PHP_DOCKER_RELEASE} \
  -t ${container} .

docker run -it -v ${PWD}:/app \
  --workdir /app \
  --add-host "host.docker.internal:host-gateway" \
  -p ${SERVER_PORT}:${SERVER_PORT} \
  -e XDEBUG_CONFIG="client_host=host.docker.internal" \
  -e XDEBUG_SESSION="PHPSTORM" \
  -e SERVER_PORT=${SERVER_PORT} \
  -e PROJECT_NAME=${PROJECT_NAME} \
  --entrypoint /bin/bash ${container}

