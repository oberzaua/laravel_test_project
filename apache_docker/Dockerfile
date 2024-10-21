FROM httpd:2.4-alpine

#RUN apk update; apk upgrade;


# Copy Apache virtual host file to proxy .php requests to PHP container
COPY apache-vhost.conf /usr/local/apache2/conf/apache-vhost.conf
COPY apache-vhostlaravel.conf /usr/local/apache2/conf/apache-vhostlaravel.conf
RUN echo "Include /usr/local/apache2/conf/apache-vhost.conf" \
    >> /usr/local/apache2/conf/httpd.conf
RUN echo "Include /usr/local/apache2/conf/apache-vhostlaravel.conf" \
    >> /usr/local/apache2/conf/httpd.conf

RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf && \
    sed -i 's#AllowOverride [Nn]one#AllowOverride All#' /usr/local/apache2/conf/httpd.conf
