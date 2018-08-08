# HOWTO(s)

## Create project

```
composer create-project symfony/website-skeleton my-project
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev
composer require laravel/homestead --dev
```
```
php vendor/bin/homestead make
```

Next, run the `vagrant up` command in your terminal and access your project at  http://homestead.test in your browser. Remember, you will still need to add an /etc/hosts file entry for homestead.test or the domain of your choice.

## Migrations

```$xslt
php bin/console doctrine:database:create
php bin/console make:entity
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Fixtures

```$xslt
php bin/console doctrine:fixtures:load
```
