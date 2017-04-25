<?php
    echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
    
    ?>


<?php 
var_dump(extension_loaded('curl'));

echo phpinfo();?>