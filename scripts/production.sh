#!/usr/bin/env bash

PACKAGE_VERSION=$(cat package.json \
  | grep version \
  | tail -1 \
  | awk -F: '{ print $2 }' \
  | sed 's/[",]//g')

__DIR=`dirname $PWD/$0`


rm -rf public/app || true

yarn run build:prod && git add public package.json \
 && git commit -m ":package: Build ${PACKAGE_VERSION}" \
 && node ${__DIR}/upload-source-maps.js
