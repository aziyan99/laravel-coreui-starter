<p align="center"><a href="javascript:void(0);" target="_blank"><img src="https://i.ibb.co/qBHySrq/laravel-coreui-logo.png" width="100"></a></p>

<hr>

![ss1](https://i.ibb.co/JrrtgsJ/laravel-coreui.png)


# Laravel Coreui Starter
Simple admin dashboard starter with laravel and coreui

# Installation ⚙️
copy `.env-example` file and update the database credentials section according to yours.

First install the depedencies using composer and npm
```console
composer install
```
next, generate the key
```console
php artisan key:generate
```
next, running the migration and seeder
```console
php artisan migrate:fresh --seed
```
last make a storage link
```console
php artisan storage:link
```
optionally, refresh cache
```console
php artisan cache:clear
```

# Default Authentication Credentials
|Email|Password|Role|
| ------ | ------ | ------ |
| admin@example.test | admin@example.test | `admin` |

ACL or access control level using is custom made by using `Gate`.

# Troubleshooting 🔧
1. Deprecated: Return type of `Illuminate\Container\Container::offsetExists($key)`
   - Run `composer update`
   - Updating php version in `composer.json` [https://stackoverflow.com/questions/70245146/php-deprecated-issue-when-running-artisan-command](https://stackoverflow.com/questions/70245146/php-deprecated-issue-when-running-artisan-command)
