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

> /*

>>  		 * para llamar al servicio de monolog ubicado en services.yml y config_dev

> >		 * $this->get('app.listener.command_exception')->exampleMethod('kakkakaka');

>  		 
>  */

##### Viernes 17/ago Preparando el servicio rest

link: https://www.cloudways.com/blog/rest-api-in-symfony-3-1/


 #### martes 21/agosto/2018
 
 ### Creacion de tarea en cron usando el so Linux
 
Comando utilizados:

Para editar crontab y programar las tareas:

>crontab -e  

Ver lista de tareas:

>crontab -l

Reiniciar servicio en Ubuntu:

> sudo service cron restart

*stop-status

Linea utilizada en cron tab modo de prueba escribiendo en un log ubicado en documentos:

$ * * * * * /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/csvReaderDaemon.sh >> /home/maggie/Documentos/prueba.log 2>&1

Cada 10 minutos

$> */10 * * * * /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/csvReaderDaemon.sh >> /home/maggie/Documentos/prueba.log 2>&1

REFERENCIAS:
 
https://www.youtube.com/watch?v=1flpMHngRGI

https://www.desarrollolibre.net/blog/linux/ejecutar-script-automaticamente-con-cron-en-linux#.W3wmDuhKi1s

https://www.cyberciti.biz/faq/howto-linux-unix-start-restart-cron/

https://symfony.com/legacy/doc/more-with-symfony/1_4/es/13-leveraging-the-power-of-the-command-line

https://vabadus.es/blog/crear-tareas-programadas-en-symfony2-mediante-comandos-de-consola


 
 
 


