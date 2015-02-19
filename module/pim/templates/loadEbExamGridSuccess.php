<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$li = $sf_data->getRaw('childDiv');
$myArr = $sf_data->getRaw('ebExamIDArr');


echo json_encode(array("List" => $li, "ebExamIDArr" => $myArr, "generalComment" => $generalComment));
?>
