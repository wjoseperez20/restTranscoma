csv-import-example
==================

An example of importing a CSV into two entities, one related to the other, using
a Symfony 3 console command and League CSV.

``` language-bash
➜  csv-import-example php bin/console doctrine:schema:update --force
Updating database schema...
Database schema updated successfully! "3" queries were executed

➜  csv-import-example php bin/console csv:import                      

Attempting import of Feed...
============================

 1000/1000 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

                                                                                                                        
 [OK] Command exited cleanly!                                                                                           
                                                                                                                        
```

### Jueves 9/08/2018

#### para generar las entidades en doctrine:

>php bin/console doctrine:generate:entity

#### para actualizar la b/d

>php bin/console doctrine:schema:update --force

#### creacion de un nuevo comando (clase) para ejecutarlo en consola:

>php bin/console csv:excel

para ello se registro el comando en el archivo /app/config/services.yml

#### prueba de la lectura del archivo .csv y la escritura en la base de datos con el siguiente comando:

>php bin/console csv:import

#### consulta del tipo de dato de los campos

> mysql> describe postal;

#### Formato para realizar los logguer con monolog

        $logger = $this->get('logger');
        $logger->info('I just got the logger -----');
        $logger->err('An error occurred');
        $logger->alert('An alert ocurred');
        $logger->emergency('An emergency occurred');
        $logger->warning('A warning occurred');
        $logger->critical('I left the oven on!', array(
        // include extra "context" info in your logs
            'cause' => 'in_hurry',
        ));

