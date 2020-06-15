# Distributed worker

## Getting Started

Please fill .env file to match your environment config. 

add the following line: 

``
MESSENGER_TRANSPORT_DSN=doctrine://default
``

### Installing

```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### Instruction

To add the url please run: 

```
 bin/console app:add-url https://<xxxxxxx>.com
```
It will add the url upon successful validation to the database and to the queue for async processing. 

To process queues in the background please run: 

```
bin/console messenger:consume --limit=1
```


It will take one job and process in the background. Feel free to run the command in multiple shells. 

***
Alternatively please execute below to consume messages in the background whenever queue job is produced.

```
bin/console messenger:consume 
```
***


### fixing styling

```
vendor/bin/ecs check src --fix

```

## Authors

* **Jakub Babiuch** 



