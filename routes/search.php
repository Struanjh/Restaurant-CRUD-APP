<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $dataFile = file_exists(FILEPATH);

    if(isset($_POST['submit']) && $dataFile) {
        $json_data = readData();
        $restaurants = listRestaurants($json_data);
        if(count($restaurants) === 0) {
            $outcomeMsg = "There are no restaurants to search!";
        } else {
            //Indexed Arr
            $formSubmission = handleFormSubmission("SEARCH", false);
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
    } else {
        $outcomeMsg = "There are no restaurants to search!";
    }
   