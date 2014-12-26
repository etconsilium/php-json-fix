#!/bin/bash
echo '###'
echo '# type'
echo '#    extension=runkit.so'
echo '#    runkit.internal_override=1'
echo '# somewhere in php.ini after install'
echo '###'
echo
read -p 'Press any key...'
sudo apt-get install php5-dev
git clone https://git.php.net/repository/pecl/php/runkit.git
cd runkit/
phpize
#./configure --enable-runkit --enable-runkit-modify
./configure
make
sudo make install
#sudo echo "extension=runkit.so \n runkit.internal_override=1 \n" > /etc/php5/cli/conf.d/runkit.ini
exit 0
# tnhx 2 http://forum.sources.ru/index.php?showtopic=307683&view=showall #19
