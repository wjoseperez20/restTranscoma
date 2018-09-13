csvReaderJson
================

A Symfony project created on August 29, 2018, 10:53 pm.

csv-import-document Dua
========================

A fragment code of importing a CSV into Dua documents, using
a Symfony 3 console command and League CSV.

``` language-bash

➜  csv-import: php bin/console csv:import                      

Attempting import of Feed...
============================

 1000/1000 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

                                                                                                                        
 [OK] Command exited cleanly!                                                                                           
                                                                                                                        
```

You have to install the next library to able to use the logs:

> sudo apt-get install php7.1-curl 

##### Fri aug/17 Setup the rest services:

link: https://www.cloudways.com/blog/rest-api-in-symfony-3-1/


##### Thu aug/21
 
> #### Creating cron task using the Linux-Ubuntu OS.
 
The following commands:

To edit crontab and schedule tasks:

>crontab -e  

Watch list of tasks:

>crontab -l

Restart service on Ubuntu:

> sudo service cron restart

>                   *stop-status

Line used in cron tab test mode:

> $ * * * * * /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/csvReaderDaemon.sh >> /home/maggie/Documentos/prueba.log 2>&1

Each 10 minutes

> $ */10 * * * * /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/csvReaderDaemon.sh >> /home/maggie/Documentos/prueba.log 2>&1

REFERENCES:
 
https://www.youtube.com/watch?v=1flpMHngRGI

https://www.desarrollolibre.net/blog/linux/ejecutar-script-automaticamente-con-cron-en-linux#.W3wmDuhKi1s

https://www.cyberciti.biz/faq/howto-linux-unix-start-restart-cron/

https://symfony.com/legacy/doc/more-with-symfony/1_4/es/13-leveraging-the-power-of-the-command-line

https://vabadus.es/blog/crear-tareas-programadas-en-symfony2-mediante-comandos-de-consola

#### Notes:

Inside the file parameters.yml you can find the name of the headers of the original documents (DuaPartidas). Inside
the folder Handle File is the function that performs the reading, once read, this returns an array, and this function 
seeks the key and returns its value. In this case the key is the column and the value is the name of headers. In addition 
you will find the directories of the loggers for command and controller.


Hay que instalar la libreria de phpoffice/phpspreadsheet 
Para ello tiene que estar instalado o habilitado lo siguiente

* php_xml

* php_zip se instala con  sudo apt-get install php7.1-zip

* php_gd2 enabled (if not compiled in)

* composer require phpoffice/phpspreadsheet


Referencia :https://phpspreadsheet.readthedocs.io/en/develop/

Nota: hay que reiniciar el servidor de apache y el de symfony una vez se haya instalado.