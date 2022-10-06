<?php
    include "../_functions.php";
    include "../includes/_constants.php";


    $json_data = readData();
    $restaurantNames = listRestaurantNames($json_data);

    ///----------------------CREATE--------------------//
    //Indexed Arr
    $formSubmission = handleFormSubmission("ADD");
    //Assoc Arr
    $formValidation = $formSubmission[0];
    //Assoc Arr
    $submittedData = $formSubmission[1];
    //Boolean
    $validationPassed = $formSubmission[2];
    if($validationPassed) {
        //Creates file if it doesn't exist and returns true if file was created...
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
 


     
   