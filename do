#!/usr/bin/env sh

DC_FILE=${DC_FILE:-docker-compose.yml}

composer () {
    docker-compose -f ${DC_FILE} exec --user=www-data php composer --working-dir=/var/www/symfony $*
}

console () {
    docker-compose -f ${DC_FILE} exec --user=www-data php php /var/www/symfony/bin/console $*
}

npm () {
    docker-compose -f ${DC_FILE} run --rm --user=node node yarn $*
}

yarn () {
    docker-compose -f ${DC_FILE} run --rm --user=node node yarn $*
}

encore () {
    docker-compose -f ${DC_FILE} run --rm --user=node node encore $*
}

$*
