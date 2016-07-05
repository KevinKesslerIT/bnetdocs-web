# BNETDocs: Phoenix

[![Build Status](https://travis-ci.org/BNETDocs/bnetdocs-web.svg?branch=phoenix)](https://travis-ci.org/BNETDocs/bnetdocs-web)

## Preface
BNETDocs is a web content management system (CMS) and documentation software
for the Battle.net&trade; online gaming service's protocol. It provides a means
for documenting the protocol and encouraging discussion on it.

BNETDocs is in no way affiliated with or endorsed by Blizzard
Entertainment&trade; or its brands, and is not intended to compete with
or undermine Blizzard Entertainment&trade; or Battle.net&trade;. Persons using
this software understand that the information provided within is collected
knowledge from years of observations and may be inaccurate. BNETDocs does not
provide a warranty of any kind to the nature of its content. All aforementioned
trademarks are the property of their respective owners. See the LICENSE file at
the root of this repository for more info.

**BNETDocs: Phoenix** is the successor to
[BNETDocs: Redux](https://github.com/BNETDocs/bnetdocs-web/tree/redux).

## Installation

1. Clone this repository to a local directory on your development environment.
 - Recommended location: `/home/nginx/bnetdocs-local/`
2. Setup an nginx/php-fpm web server using
   [nginx-conf](https://github.com/carlbennett/nginx-conf) as the config.
3. Copy the `/etc/nginx-vhost-sample.conf` file to your local nginx.
 - Recommended location: `/etc/nginx/sites-available/local.bnetdocs.org.conf`
4. Create a symbolic link from
   `/etc/nginx/sites-available/local.bnetdocs.org.conf` to
   `/etc/nginx/sites-enabled/local.bnetdocs.org.conf`.
5. Reconfigure your `local.bnetdocs.org.conf` file as necessary to work with
   your environment. You will need to modify the `server_name` directives and
   even quite possibly remove some `server` blocks.
6. Install additional php modules:
 - php-gmp
 - php-mbstring
 - php-mcrypt
 - php-memcache
 - php-memcached
 - php-mysqlnd
 - php-pdo
 - php-pecl-geoip
 - php-pecl-http
 - php-pecl-jsonc
7. Start nginx and php-fpm on your server and ensure they begin running.
8. Import and setup the sample database.
9. Copy `/etc/config.sample.json` to `/etc/config.phoenix.json` and modify it
   to your environment.
10. Try accessing this endpoint:
   [local.bnetdocs.org](https://local.bnetdocs.org)
 - You may need to modify your `/etc/hosts` file if your development
   environment is not your localhost.
