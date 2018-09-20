#!/bin/bash

echo "Executing the send:email command"

today=`date +%d/%m/%Y`
hour=`date +%H:%M:%S`

echo "Day is: $today and the current time is: $hour"

php /home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/mailSender/bin/console send:email