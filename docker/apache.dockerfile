FROM httpd
COPY $PWD/src/apache/conf/my-httpd.conf /usr/local/apache2/conf/
RUN echo "Include /usr/local/apache2/conf/my-httpd.conf" \
    >> /usr/local/apache2/conf/httpd.conf
RUN apt-get update && apt-get -y install curl
