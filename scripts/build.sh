#!/bin/bash
set -eEuo pipefail

ROOT="$(cd "$(dirname "$0")/.." &>/dev/null; pwd -P)"
echo ROOT: $ROOT
alias docker="sudo docker"

function build_php(){
	docker build -t php-app -f $ROOT/docker/php.dockerfile $ROOT
}
function build_apache(){
	read -p "Enter domain name: " domain
	[ $(wc -w <<< "$domain") -ne 1 ] && echo "Error: Need a domain" && exit 1
	docker build -t apache-app \
		--build-arg "domain=$domain" \
		-f $ROOT/docker/apache.dockerfile $ROOT
}
function build_mysql(){
	docker build -t mysql-app -f $ROOT/docker/mysql.dockerfile $ROOT
}
function run_php(){
	docker run --rm -dit \
	    -v $ROOT/src/php:/var/www/html/ \
	    --net net1 \
	    --name php_running php-app
}
function run_apache(){
	docker run --rm -dit \
	    -p 80:80 \
	    -p 443:443 \
	    -v $ROOT/src/apache/public-html:/var/www/html/ \
	    -v $ROOT/src/apache/logs:/var/log/apache2/ \
	    -v $ROOT/src/apache/letsencrypt:/etc/letsencrypt/live/site/ \
	    --net net1 \
	    --name apache_running apache-app
}
function run_mysql(){
	docker run --rm -d \
	    --net net1 \
	    --name mysql_running mysql-app
}
function connect_mysql(){
	# create another instance to use the cli
	docker run --rm -it \
	    --net net1 mysql \
	    mysql -hmysql_running -uuser -p
}
function create_network(){
	docker network create net1
}
function provision_certs(){
	docker run -it --rm --name certbot \
	  -p 80:80 \
		-v $ROOT/letsencrypt:/etc/letsencrypt \
		-v $ROOT/letsencrypt/lib:/var/lib/letsencrypt \
		certbot/certbot certonly --register-unsafely-without-email
}

function main(){
	PS3="What would you like to do?"$'\n'" -> "
	COLUMNS=12
	select action in \
		build_php \
		build_apache \
		build_mysql \
		run_php \
		run_apache \
		run_mysql \
		connect_mysql \
		create_network \
		provision_certs \
		"build all" \
		"run all" \
		"stop all"
	do
	case $action in
		build_php )
			build_php
			break;;
		build_apache )
			build_apache
			break;;
		build_mysql )
			build_mysql
			break;;
		run_php )
			run_php
			break;;
		run_apache )
			run_apache
			break;;
		run_mysql )
			run_mysql
			break;;
		connect_mysql )
			connect_mysql
			break;;
		create_network )
			create_network
			break;;
		provision_certs )
			provision_certs
			break;;
		"build all" )
			build_php
			build_apache
			build_mysql
			break;;
		"run all" )
			run_php
			run_apache
			run_mysql
			break;;
		"stop all" )
			docker stop $(docker ps -a -q)
			break;;
	esac
	done
}
main



