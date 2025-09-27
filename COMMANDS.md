# Docker

## vlez do kontejneru

``` CLI
docker exec -it easy_learn_php sh
```

# Symfony

## Clear cache

``` CLI
bin/console cache:clear
```

## Doctrine create migration

``` CLI
bin/console doctrine:migrations:diff
```

## Doctrine migrate all migrations

``` CLI
bin/console doctrine:migrations:migrate
```


# Code analysis

## phpstan:

``` CLI
vendor/bin/phpstan analyse src
```

## phpcs:

``` CLI
vendor/bin/phpcs src
```
## phpcbf:

``` CLI
vendor/bin/phpcbf src
```


# Easy admin
``` CLI
bin/console make:admin:dashboard
```

``` CLI
bin/console make:admin:crud
```