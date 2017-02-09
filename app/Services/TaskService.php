<?php

namespace Services;

class TaskService {
    
    private $file = '/home/archita/Documents/MyDocs/codes/productSorting/products.csv';
    private $maxLines = 1000;


    public function getOrderedList($type) {
	$fileDataArr = $this->getFileData(); // converts csv file to associate array based on keys
	$fileDataArrBasedOnPrice = $this->getFileDataArrBasedOnPrice($fileDataArr); // adds price per grams index in associate array of product
	$fileDataBasedOnSortingKey = $this->sortFileDataBasedOnSortingKey($fileDataArrBasedOnPrice,$type); //sort data based on product per gm
        return $this->createResponseData($fileDataBasedOnSortingKey);
    }
    
     // converts csv file to associate array based on keys
    protected function getFileData() {
    	if (($handle = fopen($this->file, "r")) !== FALSE) {
            return $this->createFileDataArr($handle);
    	}
    	fclose($handle);
    }

    protected function createFileDataArr($handle) {
	$fileDataArr = array();
	$columnArr = array();
	$count = 0;
        // fgetcsv reads csv data per array row
	 while (($dataArr = fgetcsv($handle, $this->maxLines, ",")) !== FALSE) { 
		if($count == 0) {
			foreach($dataArr as $column){
				$columnArr[] = $column;
			}
			$count++;
			continue;
                } else {
			$row = 0;
			foreach($dataArr as $data) {
				$fileDataArr[$count-1][$columnArr[$row]] = $data;
				$row++;
			}
			$count++;
		}
         }
	 return $fileDataArr;
    }

    // adds price per grams index in associate array of product
    protected function getFileDataArrBasedOnPrice($fileDataArr) {
	foreach($fileDataArr as $key => $fileData) {
		if($fileData['Unit'] == 'Kg') {
			//$fileDataArr[$key]['Unit'] = 'Grams';
			$weight = $fileDataArr[$key]['Weight']*1000;
		} else {
                    $weight = $fileDataArr[$key]['Weight'];
                }
		$fileDataArr[$key]['pricePerGm'] = $fileDataArr[$key]['Price']/$weight;
	}
	return $fileDataArr;
    }
    
    //sort data based on product per gm
    protected function sortFileDataBasedOnSortingKey($fileDataArr,$type) {
	$fileDataBasedOnSortingKey = array();
	foreach($fileDataArr as $key => $value) {
		$fileDataBasedOnSortingKey['pricePerGm'][$key] = $value['pricePerGm'];
	}
        if(count($fileDataBasedOnSortingKey)>0) {
            array_multisort($fileDataBasedOnSortingKey['pricePerGm'],$type,$fileDataArr);
        } else {
            $fileDataArr = array();
        }
	return $fileDataArr;
    }
    
    protected function createResponseData($fileDataBasedOnSortingKey) {
        $responseArr = array();
        foreach($fileDataBasedOnSortingKey as $data) {
            unset($data['pricePerGm']);
            $responseArr[] = implode(",", $data);
        }
        return $responseArr;
    }

    public function getProductIdBasedList($type,$productIdArr) {
        $fileDataArr = $this->getFileData();  // converts csv file to associate array based on keys
        $fileDataArrBasedOnPrice = $this->getFileDataArrBasedOnPriceAndProductId($fileDataArr,$productIdArr); // adds price per grams index in associate array of product
	$fileDataBasedOnSortingKey = $this->sortFileDataBasedOnSortingKey($fileDataArrBasedOnPrice,$type); //sort data based on product per gm
        return $this->createResponseData($fileDataBasedOnSortingKey);
    }
    
    // adds price per grams index in associate array of product
    protected function getFileDataArrBasedOnPriceAndProductId($fileDataArr,$productIdArr) {
	foreach($fileDataArr as $key => $fileData) {
                if(!in_array($fileData['Product Code'], $productIdArr)) {
                    unset($fileDataArr[$key]);
                    continue;
                }
		if($fileData['Unit'] == 'Kg') {
			//$fileDataArr[$key]['Unit'] = 'Grams';
			$weight = $fileDataArr[$key]['Weight']*1000; //converting kg to gms
		} else {
                    $weight = $fileDataArr[$key]['Weight'];
                }
		$fileDataArr[$key]['pricePerGm'] = $fileDataArr[$key]['Price']/$weight;
	}
	return $fileDataArr;
    }
}
