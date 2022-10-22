<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $dataFile = file_exists(FILEPATH);
    //If data file exists already check for duplicate restaurant names during validation... otherwise don't
    // if($dataFile) {
    //     $json_data = readData();
    //     $restaurants = listRestaurants($json_data);
    // } else {
    //     $successMsg = "No restaurants available to edit";
    // }

    //Check if data file actuallt exists and read the data if it does..
    if($dataFile) {
        $json_data = readData();
    } else {
        $successMsg = "No restaurants available to edit";
    }

    //Check if the data file is empty
    if(!isset($json_data)) {
        $restaurants = [];
        $successMsg = "No restaurants available to edit";
    } else {
        //The file contains data.. get the restaurant names and id's
        $restaurants = listRestaurants($json_data);
    }


    // if(!$dataFile || count($restaurants) === 0) $successMsg = "No restaurants available to edit";

    if(isset($_POST['edit'])) {
        if(!$dataFile || count($restaurants) === 0) {
            $successMsg = "No restaurants available to edit!";
        } elseif(!isset($_POST['restaurant_name'])) {
            $successMsg = "Select a restaurant to edit!";
        } else {
            $currNameID = splitValues($_POST["restaurant_name"],"|");
            $currId = $currNameID[0];
            $currName = $currNameID[1];
            $currSelecData = filterData($json_data, ['id' => $currId]);
        }
    }

    if(isset($_POST['delete'])) {
        if(!$dataFile || count($restaurants) === 0) {
            $successMsg = "No restaurants available to delete!";
        } elseif(!isset($_POST["restaurant_name"])) {
            $successMsg = "Select A Restaurant To Delete!";
        }
        else {
            $nameID = splitValues($_POST["restaurant_name"],"|");
            $id = $nameID[0];
            $updatedData = deleteAnEntry($json_data, $id);
            writeData($updatedData);
            //Re-read the data and re-list restaurant names to show updated dropdown list for the user....
            $json_data = readData();
            $restaurants = listRestaurants($json_data);
            $successMsg = "Record Deleted Successfully!";
        }
    } 


    if(isset($_POST['submit'])) {
        if(!$dataFile || count($restaurants) === 0) {
            $successMsg = "No restaurants available to edit!";
        } else {
            //Indexed Arr
            $formSubmission = handleFormSubmission("EDIT", false);
            //Assoc Arr
            $formValidation = $formSubmission[0];
            //Assoc Arr
            $submittedData = $formSubmission[1];
            //Boolean
            $validationPassed = $formSubmission[2];
            if($validationPassed) {
                //Assoc Area
                $updatedData = updateData($json_data, $submittedData);
                writeData($updatedData);
                $successMsg = "Record Updated Successfully!";
            } else {
                $successMsg = "Fix the errors and try again!";
            }
        }
    }
   