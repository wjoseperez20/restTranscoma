#!/bin/bash

echo "Ejecutando comando CsvImport"

today=`date +%d/%m/%Y`
hour=`date +%H:%M:%S`

echo "en el dia $today y la hora actual es: $hour"

php /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderMySql/bin/console csv:import
