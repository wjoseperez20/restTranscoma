<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Reader;
use League\Csv\Reader;

/* Factory import */
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\HandleFileFactory;

/**
 * Class BashController
 * @package AppBundle\Controller
 */
class BashController extends Controller
{

	const CLASS_NAME = BashController::class;

	/**
	 * @return Response
	 * @Route("execute")
	 * @throws \Exception
	 * This run the .sh from the browser
	 */
	public function runBashAction()
	{
        $handle_file =HandleFileFactory::getReadFileYml();
        $log_directory= $handle_file->getColumn('log_directory_controller');
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler($log_directory);
        $logger->pushHandler($handler);
		try
		{
			$message= system('./../csvReaderDaemon.sh') . "\n";
			return new Response($message);
		}
		catch (\RuntimeException $ee)
		{
			$logger->error("({$ee->getCode()}) Message: '{$ee->getMessage()}' in file: '{$ee->getFile()}' in line: {$ee->getLine()}");
			return new Response(" Execution time exceeded ". $ee, Response::HTTP_REQUEST_TIMEOUT);
		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			return new Response("The script could not be executed ". $e, Response::HTTP_NOT_FOUND);
		}
	}

    /**
     * reading files in xls or xlsx formats
     * @Route("read")
     * @throws \Exception
     */
    public function readExternalDocument()
    {
        try {

            $spreadsheet = IOFactory::load(__DIR__."/../../../assets/postalP.xlsx");
            $data = [];
       //     $cellValue=$spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,1)->getValue();

            $sheet=$spreadsheet->getSheet(0);
            $highestRow= $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $headings = $sheet->rangeToArray('A1:'.$highestColumn . 1,
                NULL,TRUE,FALSE);

            for ($row = 2; $row <= $highestRow; $row++){
                //  Read a row of data into an array
                $rowData= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,TRUE,FALSE);
                $rowData = array_combine($headings[0], $rowData[0]);
                $data[]=$rowData;
            }
           // print_r($data);
            return $data;
        }
        catch (\Exception $exception)
        {
            throw $exception;
        }
    }
        /**
        reading files in xls or xlsx formats
        * @Route("leer")
        * @throws \Exception
             */
    public function consultar(){
        $reader = Reader::createFromPath('/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/assets/dataPartidasDua.csv');
        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();
        $data = [];
        foreach ($results as $row){
            $data[]=$row;
        }
      //  print_r($data);
        return $data;
    }
    /**
     *
     */
    public function readCsv()
    {
        try {
            $reader = new Reader\Csv();
            $reader->setInputEncoding('CP1252'); // reading input format windows
            $reader->setDelimiter(';');
            $reader->setEnclosure('');
            $reader->setSheetIndex(0); // specify which sheet to read from CSV
            $spreadSheet = $reader->load("assets/dataPartidasDua.csv");
            $data = [];
            foreach ($spreadSheet as $row)
            {

            }
        }
        catch (\Exception $e)
        {

        }


    }
}