#!/bin/bash

echo "Ejecutando comando CsvImport"

today=`date +%d/%m/%Y`
hour=`date +%H:%M:%S`

echo "en el dia $today y la hora actual es: $hour"

php /home/wjoseperez/Documents/Transcend/Transcoma/restTranscoma/csvReaderJson/bin/console csv:import
