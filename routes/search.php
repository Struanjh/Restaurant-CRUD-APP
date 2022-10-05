<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    if(isset($_POST['submit'])) {
        $json_data = readData();
        $restaurantNames = listRestaurantNames($json_data);
        //Indexed Arr
        echo '<br>';
        $formSubmission = handleFormSubmission("SEARCH");
        // //Assoc Arr
        $submittedData = $formSubmission[1];
        //Remove empty array elements
        foreach($submittedData as $key => $value) {
            if (empty($submittedData[$key])){
                unset($submittedData[$key]);
            }
        }
        $searchResults = filterData($json_data, $submittedData);
        $outcomeMsg = countSearchResults(count($searchResults));
    }
   