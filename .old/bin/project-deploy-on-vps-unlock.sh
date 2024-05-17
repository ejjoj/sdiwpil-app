#!/bin/bash

REAL_PATH="$(cd "$(dirname "$0")" && pwd -P)";
# shellcheck disable=SC2006
DIR=`dirname "${REAL_PATH}"`;
BIN_DIR="$DIR/vendor/bin";

# shellcheck disable=SC2068
"${BIN_DIR}"/deployer.phar deploy:unlock $@
