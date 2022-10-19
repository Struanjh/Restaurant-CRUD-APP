<?php

    include "../_functions.php";
    include "../includes/_constants.php";

    $dataFile = file_exists(FILEPATH);
    //If data file exists already check for duplicate restaurant names during validation... otherwise don't
    if(isset($_POST['submit'])) {
        if($dataFile) {
            $json_data = readData();
            if($json_data !== null) {
                $restaurants = listRestaurants($json_data);
            } else {
                $restaurants = null;
            }// echo gettype($json_data);// echo '<br>' . '<br>';
            $formSubmission = handleFormSubmission("ADD", false);
        } else {
            $formSubmission = handleFormSubmission("ADD", true);
        } 
        //Assoc Arr
        $formValidation = $formSubmission[0];
        //Assoc Arr
        $submittedData = $formSubmission[1];
        //Boolean
        $validationPassed = $formSubmission[2];
        if($validationPassed) {
            //Give the entry a unique ID
            $submittedData = array_merge(array("id" => uniqid()), $submittedData);
            //Create file if it doesn't exist
            $fileCreated = create_file(FILEPATH);
            if(!$fileCreated && $json_data!== null) {
                //If the file already existed, append new data to existing data
                $newData = appendNewData($json_data, $submittedData);
            } else {
                //A new file was created so just pass an empty array as starting data...
                $newData = appendNewData([], $submittedData);
            }
        writeData($newData);
        $successMsg = "Record Added Successfully!";
        } else {
            dbg("VALIDATION RESULTS", $validationPassed);
            $successMsg = "Fix the errors and try again!";
        }
    }

 


     
   