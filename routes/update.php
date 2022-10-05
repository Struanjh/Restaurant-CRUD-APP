<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $json_data = readData();
    $restaurantNames = listRestaurantNames($json_data);

    if(isset($_POST['edit'])) {
        echo($_POST['restaurant_name']);
        $currSelecData = filterData($json_data, ['name' => $_POST['restaurant_name']]);
        print_r($currSelecData);
    }


    if(isset($_POST['submit'])) {
        //Indexed Arr
        $formSubmission = handleFormSubmission("EDIT");
        //Assoc Arr
        $formValidation = $formSubmission[0];
        //Assoc Arr
        $submittedData = $formSubmission[1];
        //Boolean
        echo "SUBMITTED DATA!" . "<br>";
        print_r($submittedData);
        echo '<br>';
        echo "FORM VALIDATION DATA!" . "<br>";
        print_r($formValidation);
        echo '<br>';
        $validationPassed = $formSubmission[2];
        if($validationPassed) {
            //Assoc Area
            $updatedData = updateData($json_data, $submittedData);
            writeData($updatedData);
            $successMsg = "Record Updated Successfully!";
        } else {
            $successMsg = "Please fix the errors and try again!";
        }
    }
   