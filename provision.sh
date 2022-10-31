#!/bin/sh

dnf upgrade

# Install Commands
yum -y install \
    unzip vim httpie tree \
    "Development Tools" zlib-devel openssl-devel ncurses-devel libffi-devel sqlite-devel.x86_64 readline-devel.x86_64 bzip2-devel.x86_64
yum -y install yum-utils git
git --version

# Disable SELinux
setenforce 0
sed -i 's/^SELINUX=enforcing/SELINUX=disabled/' /etc/selinux/config

# Install Docker & docker-compose
dnf config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
dnf makecache fast
dnf install -y docker-ce
systemctl enable docker
systemctl start docker
curl -L https://github.com/docker/compose/releases/download/v2.12.2/docker-compose-`uname -s`-`uname -m` > docker-compose
mv docker-compose /usr/local/bin/
chmod +x /usr/local/bin/docker-compose
gpasswd -a vagrant docker
systemctl restart docker
docker -v
cd /vagrant
/usr/local/bin/docker-compose up -d --build

# Install Node.js and npm
curl -sL https://rpm.nodesource.com/setup_12.x | sudo bash -
sudo dnf -y install nodejs
node -v
npm -v

# Install the heroku cli
export PATH=/usr/local/bin:$PATH
curl https://cli-assets.heroku.com/install.sh | sh
heroku -v

# Install pyenv and Python
rm -fR ~/.pyenv
git clone https://github.com/pyenv/pyenv.git ~/.pyenv
echo 'export PYENV_ROOT="$HOME/.pyenv"' >> ~/.bash_profile
echo 'export PATH="$PYENV_ROOT/bin:$PATH"' >> ~/.bash_profile
echo -e 'if command -v pyenv 1>/dev/null 2>&1; then\n  eval "$(pyenv init -)"\nfi' >> ~/.bash_profile
source ~/.bash_profile
pyenv install 3.7.6
pyenv global 3.7.6
python --version

# Install aws cli version 1
# cf. https://github.com/aws/aws-cli
pip --version
su -l vagrant -c "pip3 install awscli --upgrade"
su -l vagrant -c "aws --version"

# Install aws cli version 2
# cf. https://docs.aws.amazon.com/ja_jp/cli/latest/userguide/install-cliv2-linux-mac.html
#curl "https://d1vvhvl2y92vvt.cloudfront.net/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
#unzip awscliv2.zip
#sudo ./aws/install
#aws2 --version

# Install aws eblic
# cf. https://github.com/aws/aws-elastic-beanstalk-cli-setup
su -l vagrant -c "git clone https://github.com/aws/aws-elastic-beanstalk-cli-setup.git"
su -l vagrant -c "./aws-elastic-beanstalk-cli-setup/scripts/bundled_installer"
echo 'export PATH="/home/vagrant/.ebcli-virtual-env/executables:$PATH"' >> /home/vagrant/.bash_profile && source /home/vagrant/.bash_profile
echo 'export PATH=/home/vagrant/.pyenv/versions/3.7.2/bin:$PATH' >> /home/vagrant/.bash_profile && source /home/vagrant/.bash_profile

# Install AWS SAM CLI
pip install aws-sam-cli
sam --version
