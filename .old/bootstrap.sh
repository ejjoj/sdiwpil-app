#!/usr/bin/env bash

# php
sudo apt-get update
sudo apt-get upgrade -y
sudo apt-get install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.4 php7.4-mysql php7.4-zip php7.4-mbstring php7.4-json php7.4-intl php7.4-imap php7.4-fpm php7.4-cli php7.4-bz2 php7.4-bcmath php7.4-opcache php7.4-xml php7.4-xsl php7.4-curl php7.4-soap git

#node
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
nvm install 16.0.0
nvm use 16.0.0

#yarn
curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt-get update && sudo apt-get install yarn

# ip and ports
sudo apt-get install fail2ban
sudo ufw allow ssh
sudo ufw allow http
sudo ufw allow https
sudo ufw allow 3306
sudo ufw enable
sudo cp /etc/fail2ban/fail2ban.conf /etc/fail2ban/fail2ban.local
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

sudo fail2ban-client status

sudo apt-get install -y iptables-persistent

# nginx
sudo apt-get install -y nginx-extras
sudo systemctl enable nginx.service #Auto-start for systemd

# mysql
sudo apt-get install -y mysql-common mysql-server mysql-client
sudo mysql << EOF
CREATE DATABASE sdiwpil;
CREATE USER 'sdiwpil'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON sdiwpil . * TO 'sdiwpil'@'%';
FLUSH PRIVILEGES;
EOF

sudo mysql_config_editor set --login-path=client --host=localhost --user=sdiwpil --password
sudo mysql_config_editor set --login-path=mysqldump --host=localhost --user=sdiwpil --password
