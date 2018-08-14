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

### Loggers

#### Formato para realizar logger con monolog

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
        
 
 
##### Importante: El formato anterior solo es valido dentro de alguna clase controlador, ya que:
 
 > $logger = $this->get('logger');
 
 extiende de la clase Controller .
 
##### El Siguiente codigo, solo muestra en consola los eventos que ocurren dentro de algun comando/consola.

> $log = new Logger('app');

> $log->info('---');

> $log->addWarning('test logs to loggly');

> ..

Para ello hay que instalar:

> sudo apt-get install php7.1-curl 

En algun caso:

> use Psr\Log\LoggerInterface;

##### Para registrarlo en el log se usa lo siguiente, tomando en cuenta que se extienda de la clase ContainerAwareCommand:                                                   :

> $logger = $this->getContainer()->get('logger');


 

 
 
 


