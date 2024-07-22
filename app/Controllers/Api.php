<?php

namespace App\Controllers;

class Api extends BaseController
{
    /**
     * Holds the path and name of the JSON file
     */
    private $jsonFilePath = ROOTPATH.'example.json';

    /**
     * Holds the response type
     */
    private $responseType = 'json';

    /**
     * Holds the data
     */
    private $data;

    /**
     * This endpoint will return the filtered results
     * based on name and discount_percentage and the type
     */
    public function GetFilteredResults()
    {
        // Save the response type
        $this->responseType = $this->request->getGet()['type'] ?? 'json';
        // Lets check the file
        if(!file_exists($this->jsonFilePath)){
            die('File not found');
        }
        // Let's read the json file
        $jsonFile = [];
        // Open the JSON file
        $handler = fopen($this->jsonFilePath, 'r');
        // Reads the file
        $jsonFile = fread($handler, filesize($this->jsonFilePath));
        // Close the file
        fclose($handler);
        // Check if no data is found
        if(empty($jsonFile)){
            $this->data = [];
            $this->SendResponse();
        }
        // Convert JSON to array
        $this->data = json_decode($jsonFile, true);
        // When no filter is applied
        if(!isset($this->request->getGet()['name']) && !$this->request->getGet()['discount_percentage']){
            // Send response
            $this->SendResponse();
        }
        // Filter the data by name and discount_percentage
        $this->data = array_filter($this->data, function($item){
            //
            if($this->request->getGet()['name'] && $this->request->getGet()['name'] !== $item['name']){
                return false;
            }
            //
            if($this->request->getGet()['discount_percentage'] && $this->request->getGet()['discount_percentage'] !== $item['discount_percentage']){
                return false;
            }
            //
            return true;
        });
        // Send back the response
        $this->SendResponse();
    }

    /**
     * Send response back to the client
     */
    private function SendResponse(){
        //
        header('Content-Type: '.($this->responseType === 'json' ? 'application/json' : 'application/xml').'');
        //
        if($this->responseType == 'json'){
            echo json_encode($this->data);
        } else{
            echo arrayToXML($this->data, new \SimpleXMLElement('<root />'), 'item');
        }
        //
        exit(0);
    }
}
