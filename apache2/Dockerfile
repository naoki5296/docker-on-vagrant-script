FROM almalinux
#WORKDIR /vagrant_contents
RUN dnf install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN dnf install -y https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf install procps -y
RUN dnf module enable php:remi-8.1 -y
RUN dnf install -y httpd
RUN dnf install -y php
RUN dnf install -y php-mysql
RUN dnf install -y nodejs npm
RUN npm install -g n
RUN n stable
RUN dnf remove -y nodejs npm
COPY vhost.conf /etc/httpd/conf.d/vhost.conf
COPY httpd-foreground /usr/local/bin/
EXPOSE 80
CMD ["/usr/local/bin/httpd-foreground"]
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]
CMD ["/usr/sbin/php-fpm"]

RUN dnf install -y openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:vagrant' | chpasswd
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed -i 's/#PasswordAuthentication/PasswordAuthentication/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

RUN ssh-keygen -t rsa -f /etc/ssh/ssh_host_rsa_key
RUN ssh-keygen -t ed25519 -f /etc/ssh/ssh_host_ed25519_key

EXPOSE 443
CMD ["/usr/sbin/sshd", "-D"]
# CMD ["npm", "run", "dev"]
