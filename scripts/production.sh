#!/usr/bin/env bash

PACKAGE_VERSION=$(cat package.json \
  | grep version \
  | tail -1 \
  | awk -F: '{ print $2 }' \
  | sed 's/[",]//g')

rm -rf public/js public/css public/fonts public/vendor.*.js public/manifest.*.js public/vendor.*.js.map public/manifest.*.js.map || true
yarn run build:prod
git add --force public
git commit -m "Build ${PACKAGE_VERSION}"
