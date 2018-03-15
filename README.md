<p align="center">safeboda</p>

<p align="center">
<a href="https://travis-ci.org/mogetutu/safeboda"><img src="https://travis-ci.org/mogetutu/safeboda.svg?branch=master" alt="Build Status"></a>
</p>

#### Installation
Clone repo `git clone git@github.com:mogetutu/safeboda.git`

Install or update Homebrew to the latest version using brew update.

Install PHP and database services using Homebrew via `brew bundle`.

Check if composer, php, nginx and mysql have been installed
- `php -v`
- `nginx -v`
- `mysql --version`
- composer -V

If all services are installed, create safeboda database and create tables

```bash
$ mysql -e 'create database safeboda;' -uroot -p
$ php artisan migrate
```

Install needed libraries via composer

```bash
$ composer install
```

Next, run tests to ensure everything is working

```bash
$ vendor/bin/phpunit
```

Install Valet with Composer via `composer global require laravel/valet`. Make sure the ~/.composer/vendor/bin directory is in your system's "PATH".

Run the valet install command. This will configure and install Valet and DnsMasq, and register Valet's daemon to launch when your system starts.

#### Serving site

Change directory into safeboda. Run `valet link` and `valet secure`.

```bash
$ cd safeboda
$ valet link
$ valet secure
```


Open browser and try accessing `https://safeboda.test/api/promo-codes` You should get `{"data":[]}`


#### Endpoints
| Domain | Method    | URI                          |
|--------|-----------|------------------------------|
|        | GET|HEAD  | api/promo-codes              |
|        | POST      | api/promo-codes              |
|        | GET|HEAD  | api/promo-codes/active       |
|        | POST      | api/promo-codes/check        |
|        | POST      | api/promo-codes/deactivate   |
|        | GET|HEAD  | api/promo-codes/{promo_code} |
|        | PUT|PATCH | api/promo-codes/{promo_code} |
|        | DELETE    | api/promo-codes/{promo_code} |
|        | GET|HEAD  | api/user                     |

#### Examples
```bash
curl -X GET https://safeboda.app/api/promo-codes -k
```

```bash
curl -X GET https://safeboda.app/api/promo-codes/active -k
```

```bash
curl -X POST \
  https://safeboda.app/api/promo-codes -k \
  -H 'Content-Type: application/json' \
  -d '{
        "code": "4337897244702",
        "latitude": "-63.140778",
        "longitude": "-64.759483",
        "discount": 200,
        "active": 1,
        "expires_at": "2018-06-01"
    }'
```

```bash
curl -X POST \
  https://safeboda.test/api/promo-codes/check \
  -H 'Content-Type: application/json' \
  -d '{
       "code": "4337897244702",
       "origin": [
          "-63.140778",
          "-64.759483"
       ],
       "destination": [
          "-80.431044",
          "-103.368767"
       ]
    }'
```

```bash
curl -X POST \
  https://safeboda.test/api/promo-codes/deactivate \
  -H 'Content-Type: application/json' \
  -d '{
   "ids": [
      "201",
      "202"
   ]
}'
```
