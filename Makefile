# Makefile for building and running provision-workbench

# Variables
IMAGE_NAME = provision-workbench
CONTAINER_NAME = provision-workbench
HOST_PORT = 8000
CONTAINER_PORT = 80
MOUNT_DIR = /provision-workbench

.PHONY: all build run stop shell clean

# Default target
setup: build run

# Build the Docker image
build:
	docker build -t $(IMAGE_NAME) .

# Run the Docker container in the background
run:
	docker run -d --name $(CONTAINER_NAME) -v $(PWD):$(MOUNT_DIR) -p $(HOST_PORT):$(CONTAINER_PORT) $(IMAGE_NAME)

# Stop the Docker container
stop:
	docker stop $(CONTAINER_NAME)

# Get a shell into the running Docker container
shell:
	docker exec -it $(CONTAINER_NAME) /bin/bash

# Cache provision registry
provision-cache:
	docker exec -it $(CONTAINER_NAME) /bin/bash -c "php artisan upmind:provision:cache"

# Clean target
clean:
	docker rm -f $(CONTAINER_NAME)
	docker rmi $(IMAGE_NAME)