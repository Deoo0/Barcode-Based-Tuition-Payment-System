
<?php
$path = 'C:/xampp/php/extras/ssl/cacert.pem';
if (!file_exists($path)) {
    echo "❌ File does not exist.\n";
} elseif (!is_readable($path)) {
    echo "❌ File is not readable.\n";
} else {
    echo "✅ CA file is found and readable.\n";
}
?>
