<?php

function ggLog_encrypt($toEncrypt, $salt = null)
{
  $hash_number = 10;
  $result = hash("tiger192,4", $toEncrypt . $salt);
  for($i=0;$i<$hash_number;++$i)
    $result = hash("tiger192,4", $result . $salt);
  return $result;
}


?>
