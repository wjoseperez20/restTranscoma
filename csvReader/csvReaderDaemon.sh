
##!/bin/bash/env php
#!/bin/bash
echo "hola mundo"
#while true; do

#sleep 0.05

today=`date +%d/%m/%Y`
hour=`date +"%H:%M:%S`

echo "Hoy es el dia $today y  hora actual es: $hour"

php /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/bin/console csv:import

#while true; do
#php ./../bin/console csv:import

#echo "hola"
#sleep 0.05
#done

##!/usr/bin/env php
## app/console
#<?php

#use AppBundle\Command\CsvImportCommand;
#use Symfony\Component\Console\Application;

#$application = new Application();
#$application->add(new CsvImportCommand);
#$application->run();
#>
