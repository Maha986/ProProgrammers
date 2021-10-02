<?php
require_once 'vendor/autoload.php';
$client=new Google_Client();
$client->setClientId('4331822981-s3d4r9dn3jh36hvs1oas0j9j8723oier.apps.googleusercontent.com');
$client->setClientSecret('ixvkRaKNt7BFfb9L0PSLMvNc');
$client->refreshToken('1//04iC00-wZqxjtCgYIARAAGAQSNwF-L9Irz9sdcT7UZ_FVv4Ipex4bkZz9GNkZg2iCLkZSlOnO-xSFEEgWRW1ZZHEWE_OrAlziMVo');
$service = new Google_Service_Drive($client);

?>
