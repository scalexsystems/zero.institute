#!/usr/bin/env bash

PACKAGE_VERSION=$(cat package.json \
  | grep version \
  | tail -1 \
  | awk -F: '{ print $2 }' \
  | sed 's/[",]//g')

rm -rf public/app || true

yarn run build:prod && git add --force public package.json && git commit -m ":package: Build ${PACKAGE_VERSION}"
