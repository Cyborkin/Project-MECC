# Small, repeatable Apache + PHP image
FROM debian:bookworm-slim

ENV DEBIAN_FRONTEND=noninteractive

# Install Apache + PHP (mod_php)
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        apache2 \
        php \
        libapache2-mod-php \
        php-mysql \
        php-mbstring \
        php-xml \
        php-curl \
        ca-certificates && \
    rm -rf /var/lib/apt/lists/*

# Quiet the "Could not reliably determine the server's FQDN" warning
COPY apache/servername.conf /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

# Prefer PHP index and remove Apache's default placeholder
RUN sed -i 's/DirectoryIndex .*/DirectoryIndex index.php index.html/' /etc/apache2/mods-available/dir.conf \
    && rm -f /var/www/html/index.html

# Copy honeypot app into web root
# If your app expects a different docroot, update accordingly
COPY app/src/ /var/www/html/
COPY assets/ /var/www/html/assets/
COPY includes/ /var/www/html/includes/
COPY index.php /var/www/html/index.php
COPY login.php /var/www/html/login.php
COPY comments.php /var/www/html/comments.php

# Reasonable perms
RUN chown -R www-data:www-data /var/www/html

# Expose container port 80 (host port is chosen at run time via -p)
EXPOSE 80

# Healthcheck: simple curl to /
HEALTHCHECK --interval=30s --timeout=5s --retries=5 CMD \
    bash -c 'command -v curl >/dev/null 2>&1 || (apt-get update && apt-get install -y --no-install-recommends curl && rm -rf /var/lib/apt/lists/*); \
             curl -fsS http://127.0.0.1/ >/dev/null || exit 1'

# Run Apache in the foreground
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

