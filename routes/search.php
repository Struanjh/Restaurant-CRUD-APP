<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    if(isset($_POST['submit'])) {
        $json_data = readData();
        $restaurantNames = listRestaurantNames($json_data);
        if(count($restaurantNames) === 0) {
            $outcomeMsg = "There are no restaurants to search!";
        } else {
            //Indexed Arr
            $formSubmission = handleFormSubmission("SEARCH");
            // //Assoc Arr
            $submittedData = $formSubmission[1];
            $searchResults = filterData($json_data, $submittedData);
            //If count is 1, no search terms were entered (cuisine populated by default so always set)
            if(count($submittedData) === 1 ) {
                $outcomeMsg = "Returned all " . count($searchResults) . " available restaurants";
            } else {
                $outcomeMsg = countSearchResults(count($searchResults));
            } 
        }
    }
   