FROM httpd
COPY $PWD/src/apache/conf/my-httpd.conf /usr/local/apache2/conf/
ARG domain
ENV DOMAIN $domain
RUN echo "Include /usr/local/apache2/conf/my-httpd.conf" \
    >> /usr/local/apache2/conf/httpd.conf
