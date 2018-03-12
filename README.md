# Authentication Manager

### Requirements

1. PHP 7 and Composer
2. Yaml parser `php7.2-yaml`
3. Server modules for .htpasswd authentication.

###Set-up

######Create files (examples in repository)

* .htaccess
* .htpasswd (user: `admin` password: `admin`)
* .htgroup

######Edit config.yaml and .htaccess

* Point where .htaccess and .htgroup are stored.

######Premissions

* Set server as the owner of the files .htaccess and .htpasswd.

    `sudo chown www-data:www-data .ht*`


