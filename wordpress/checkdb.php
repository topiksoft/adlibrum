<?php
$test = mysqli_connect('localhost', 'adlibrum', 'WZ2cZI7pTe8SjhQV');
if (!$test) {
die('MySQL Error: ' . mysqli_error());
}
echo 'Database connection is working properly!';
mysqli_close($testConnection);
?>
