#!/usr/bin/env bash

yarn --no-progress
yarn run prod
git add --force public
git commit -m "Build for version $1"
