<?php
$pass = array("secret1", "secret2"); //password so it can only be used by authorized person
$dir = "u/"; //file directory, change this to w/e u want
$domain = 'YOUR_DOMAIN_HERE'; //put your whole domain here with ending slash (https://xaizone.eu/)
$randomlenght = 6; //lenght of name of your uploaded file (randomized)
$types = array('image/png', 'image/jpeg', 'image/gif'); //supported file types

function randomize($length) {
    $keys = array_merge(range(0,9), range('a', 'z'));

    $key = '';
    for($i=0; $i < $length; $i++) {
        $key .= $keys[mt_rand(0, count($keys) - 1)];
    }
    return $key;
}

if(isset($_POST['pass']) && in_array($_FILES['sharex']['type'], $types))
{
    if(in_array($_POST['pass'], $pass))
    {
        $filename = randomize($randomlenght);
        $target_file = $_FILES["sharex"]["name"];
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $dir.$filename.'.'.$fileType))
        {
            echo $domain.$dir.$filename.'.'.$fileType;
        }
            else
        {
           echo 'File upload failed - insufficient permission';
        }
    }
    else
    {
        echo 'File upload failed - invalid secret';
    }
}
elseif (isset($_POST['pass']) && !in_array($_FILES['sharex']['type'], $types))
{
    echo 'File upload failed - invalid filetype';
}
else
{
    echo 'Insufficient permission';
}
?>