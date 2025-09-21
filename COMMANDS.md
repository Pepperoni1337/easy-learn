# Symfony

## Clear cache

``` CLI
docker exec easy_learn_php bin/console cache:clear
```

## Doctrine create migration

``` CLI
docker exec easy_learn_php bin/console doctrine:migrations:diff
```

## Doctrine migrate all migrations

``` CLI
docker exec easy_learn_php bin/console doctrine:migrations:migrate
```


# Code analysis

## phpstan:

``` CLI
docker exec easy_learn_php vendor/bin/phpstan analyse src
```

## phpcs:

``` CLI
docker exec easy_learn_php vendor/bin/phpcs src
```
## phpcbf:

``` CLI
docker exec easy_learn_php vendor/bin/phpcbf src
```


