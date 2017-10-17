FROM nginx

COPY symfony.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/realworld

CMD ["nginx", "-g", "daemon off;"]