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
//          $reader  = $this->get('phpoffice.spreadsheet')->createReader('Xlsx');
//          $spreadsheet = $reader->load(__DIR__."/../../../assets/postalP.xlsx");
//          $reader = new Reader\Xlsx();
//          $spreadsheet= $reader->load(__DIR__."/../../../assets/postalP.xlsx");
            $spreadsheet = IOFactory::load(__DIR__."/../../../assets/postalP.xlsx");
            $data = []; $title =[];

            foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                $worksheetTitle = $worksheet->getTitle();
//                $data[$worksheetTitle] = [
//                    'columnNames' => [],
//                    'columnValues' => [],
//                ];
                foreach ($worksheet->getRowIterator() as $row) {
                    $rowIndex = $row->getRowIndex();
//                    if ($rowIndex > 0) {
//                        $data[$worksheetTitle]['columnValues'][$rowIndex] = [];
//                    }
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Loop over all cells, even if it is not set
                    foreach ($cellIterator as $cell) {
//                        if ($rowIndex === 0) {
//                            $data[$worksheetTitle]['columnNames'][] = $cell->getCalculatedValue();
//                        }
//                        if (($rowIndex >0) && ($rowIndex==1)){
//                            $title[] = $cell->getCalculatedValue();
//                        }
                        if ($rowIndex > 1) {
                            $data[$rowIndex][] = $cell->getCalculatedValue();
                        }
                    }
                }
            }

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