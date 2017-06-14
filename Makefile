ROOT_DIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
DOCKER_IMAGE_NAME:=gousto-recipe-api

build:
	docker build --tag $(DOCKER_IMAGE_NAME) .

test:
	docker run --rm $(DOCKER_IMAGE_NAME) ./vendor/bin/phpunit
