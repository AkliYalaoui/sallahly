<?php
function get_safe_value($conn, $str)
{
    if ($str != '')
        return mysqli_real_escape_string($conn, $str);
}
