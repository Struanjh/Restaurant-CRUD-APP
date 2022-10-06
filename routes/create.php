<?php
    include "../_functions.php";
    include "../includes/_constants.php";


    $dataFile = file_exists(FILEPATH);
    //If data file exists already check for duplicate restaurant names during validation... otherwise don't
    if($dataFile) {
        $json_data = readData();
        $restaurantNames = listRestaurantNames($json_data);
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
        //Create file if it doesn't exist
        $fileCreated = create_file(FILEPATH);
        if(!$fileCreated) {
            //If the file already existed, append new data to existing data
            $newData = appendNewData($json_data, $submittedData);
        } else {
            //A new file was created so just pass an empty array as starting data...
            $newData = appendNewData([], $submittedData);
        }
    writeData($newData);
    $successMsg = "Record Added Successfully!";
    } else {
        $successMsg = "Fix the errors and try again!";
    }

 


     
   