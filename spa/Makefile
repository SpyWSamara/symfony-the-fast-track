SHELL := /bin/bash

dev:
	API_ENDPOINT=`symfony var:export SYMFONY_PROJECT_DEFAULT_ROUTE_URL --dir=..` symfony run -d --watch=webpack.config.js npm run dev-server
.PHONY: dev

dev_stop:
	symfony server:stop
.PHONY: dev_stop
