FROM php:7.4-apache

# Composer のバージョン と ハッシュ値
ARG composer_ver=1.10.13
ARG composer_hash=5ca7445cfd48dd27c5a84aa005a47b4d9fd91132313830609875df3a6973708f

# Composer の保存先
ARG composer_path=/usr/local/bin/composer

RUN apt-get update \
  # Composer インストール
  && php -r "copy('https://getcomposer.org/download/$composer_ver/composer.phar', '$composer_path');" \
  && chmod 755 $composer_path \
  && php -r "if (hash_file('sha256', '$composer_path') !== '$composer_hash') { \
          echo '!!! Failed to install Composer !!!'; \
          unlink('$composer_path'); \
      } \
      echo PHP_EOL;" \
  # vim （省略可）
  && apt-get install -y vim \
  # unzip コマンド (composer create-project で必要)
  && apt-get install -y unzip \
  # PHP の intl 拡張 (CakePHP 4 で必要)
  && apt-get install -y libicu-dev \
  && docker-php-ext-install intl \
  # PDO MySQL 拡張
  && docker-php-ext-install pdo_mysql \
  # mod_rewrite 有効化
  && a2enmod rewrite