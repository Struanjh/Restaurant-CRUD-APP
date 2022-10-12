<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $dataFile = file_exists(FILEPATH);
    //If data file exists already check for duplicate restaurant names during validation... otherwise don't
    if($dataFile) {
        $json_data = readData();
        $restaurantNames = listRestaurantNames($json_data);
    } else {
        $successMsg = "No restaurants available to edit";
    }


    if(isset($_POST['edit'])) {
        if(!$dataFile || count($restaurantNames) === 0) {
            $successMsg = "There are no restaurants available to edit!";
        } else {
            $currSelecData = filterData($json_data, ['name' => $_POST['restaurant_name']]);
        }
    }

    if(isset($_POST['delete'])) {
        if(!$dataFile || count($restaurantNames) === 0) {
            $successMsg = "There are no restaurants available to delete!";
        } else {
            $updatedData = deleteAnEntry($json_data, $_POST['restaurant_name']);
            writeData($updatedData);
            //Re-read the data and re-list restaurant names to show updated dropdown list for the user....
            $json_data = readData();
            $restaurantNames = listRestaurantNames($json_data);
            $successMsg = "Record Deleted Successfully!";
        }
    } 


    if(isset($_POST['submit'])) {
        if(!$dataFile || count($restaurantNames) === 0) {
            $successMsg = "There are no restaurants available to edit!";
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
   