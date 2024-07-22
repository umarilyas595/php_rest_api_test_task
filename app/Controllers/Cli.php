<?php

namespace App\Controllers;

class Cli extends BaseController
{
    /**
     * Holds the path and name of the CSV file
     */
    private $csvFilePath = ROOTPATH.'example.csv';

    /**
     * Holds the path and name of the JSON file
     */
    private $jsonFilePath = ROOTPATH.'example.json';

    /**
     * Holds the path and name of the XML file
     */
    private $xmlFilePath = ROOTPATH.'example.xml';

    /**
     * Holds the CSV data
     */
    private $records = [];

    /**
     * Convert the CSV file to JSON
     * and to XML when triggered from
     * the CLI command
     */
    public function ConvertCSV(){
        // Check if the file exists
        if (!is_file($this->csvFilePath)) {
            die('No file found');
        }
        // Check the file size
        if(filesize($this->csvFilePath) === 0){
            die('File seems to be empty');
        }
        // Read the CSV file and convert it into the assoc array
        $this->ReadFile();
        // Save the data in JSON format
        $this->SaveDataAsJSON();
        // Save the data in XML format
        $this->SaveDataAsXML();
        //
        echo "The CSV file has been successfully converted to JSON and XML.";
        // Execution terminated
        exit(0);
    }

    /**
     * Reads the CSV file
     */
    private function ReadFile(){
         /**
         * Set default data holder
         *  */ 
        $data = [];
        // Open the file
        $csv = fopen($this->csvFilePath, 'r');
        // Get all the rows
        while (!feof($csv)) {
            // Save each row as array
            $data[] = fgetcsv($csv);
        }
        // Check if the data came back is empty
        if(empty($data)){
            die('Either the file format is invalid or file is empty');
        }
        // Set the columns array
        $columns = $data[0];
        //
        unset($data[0]);
        //
        $data = array_values($data);
        // Close the file
        fclose($csv);
        //
        $this->records = [];
        //
        foreach($data as $row){
            // Check if there are empty rows
            if(empty($row)){
                continue;
            }
            // Add the row into the records array
            $this->records[] = [
                $columns[0] => $row[0],
                $columns[1] => $row[1],
                $columns[2] => $row[2],
                $columns[3] => $row[3],
            ];
        }
    }

    /**
     * Saves data as json
     */
    private function SaveDataAsJSON(){
        // Opens the file
        $handler = fopen($this->jsonFilePath, 'w');
        // Save the json on file
        fwrite($handler, json_encode($this->records));
        // Close teh file
        fclose($handler);
    }

    /**
     * Saves data as json
     */
    private function SaveDataAsXML(){
        // Converts array into JSON
        $xmlData = arrayToXML($this->records, new \SimpleXMLElement('<root />'), 'item');
        // Opens the file
        $handler = fopen($this->xmlFilePath, 'w');
        // Save the json on file
        fwrite($handler, $xmlData);
        // Close teh file
        fclose($handler);
    }
}
