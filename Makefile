# Registry + tags
REGISTRY ?= docker.io
IMAGE_NS ?= cyborkin               # your Docker Hub username/org (change as needed)
IMAGE_NAME ?= honeypot-web
TAG ?= 2025-10-27                  # use semver or date tags
IMAGE := $(REGISTRY)/$(IMAGE_NS)/$(IMAGE_NAME):$(TAG)
LATEST := $(REGISTRY)/$(IMAGE_NS)/$(IMAGE_NAME):latest

.PHONY: build run stop push login

build:
	docker build -t $(IMAGE) -t $(LATEST) .

run:
	# Override HOST_PORT=8081 if 8080 is busy
	HOST_PORT?=8080
	docker run --rm -p $${HOST_PORT}:80 -v $$(pwd)/logs/apache2:/var/log/apache2 $(IMAGE)

stop:
	@echo "Use Ctrl+C for foreground runs or 'docker stop <id>' if detached."

push:
	docker push $(IMAGE)
	docker push $(LATEST)

login:
	@echo "Logging in to $(REGISTRY) ..."
	docker login $(REGISTRY)

