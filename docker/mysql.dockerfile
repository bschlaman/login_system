FROM mysql
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=user
ENV MYSQL_PASSWORD=pass
COPY $PWD/src/mysql/ /docker-entrypoint-initdb.d/
