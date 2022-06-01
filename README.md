Для разворачивания проекта нужно ввести

``
docker-compose up -d
``

Для добавление элементов сначала нужно войти в контейнер

``
 docker exec -it php_testovoe /bin/bash
``

Далее нужно использовать скрипт для добавления / удаления в redis

```
cd console/

php cache_work.php redis add {key} {value}

php cache_work.php redis delete {key}
```

