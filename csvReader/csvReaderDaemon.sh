
#!/bin/bash/env php

echo "hola mundo"
while true; do
php ./../bin/console csv:import
sleep 0.05
done
today=`date +%Y%m%d`
echo today is: $today





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
