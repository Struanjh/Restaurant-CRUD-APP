<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $json_data = readData();
    $restaurantNames = listRestaurantNames($json_data);

    if(isset($_POST['edit'])) {
        if(count($restaurantNames) === 0) {
            $successMsg = "There are no restaurants available to edit!";
        } else {
            $currSelecData = filterData($json_data, ['name' => $_POST['restaurant_name']]);
        }
    }

    if(isset($_POST['delete'])) {
        if(count($restaurantNames) === 0) {
            $successMsg = "There are no restaurants available to delete!";
        } else {
            $updatedData = deleteAnEntry($json_data, $_POST['restaurant_name']);
            writeData($updatedData);
            //Re-read the data and re-list restaurant names to show updated dropdown list for the user....
            $json_data = readData();
            $restaurantNames = listRestaurantNames($json_data);
        }
    }


    if(isset($_POST['submit'])) {
        //Indexed Arr
        $formSubmission = handleFormSubmission("EDIT");
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
   