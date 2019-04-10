<?php
function checkBoxes($array, $name)
{
    foreach ($array as $key => $value)
    {
        echo '<div class="form-check form-check-inline col-md-2">';
        echo "<input class='form-check-input' type='checkbox' name='$name' id='$key' value='$key'>";
        echo "<label class='form-check-label' for=$key'>";
        echo $value;
        echo '</label> </div>';
    }
}
?>