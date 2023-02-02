###############################################################################
# Imagem PHP-5.6 baseada na imagem base alpine instalando todo o PHP do zero
#
# Ex php7 - https://github.com/jorge07/alpine-php/blob/master/7.4/Dockerfile
# Ex php5 - https://hub.docker.com/r/gotechnies/php-5.6-alpine/dockerfile

FROM gotechnies/php-5.6-alpine

WORKDIR  /var/www/html/
