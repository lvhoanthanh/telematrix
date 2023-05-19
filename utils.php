<?php
function get_page_name()
{
  $filePath = $_SERVER['PHP_SELF'];
  $fileName = pathinfo($filePath, PATHINFO_BASENAME);
  return $fileName;
}

function convertToTitleCase($str)
{
  $dotIndex = strrpos($str, '.');
  if ($dotIndex !== false) {
    $str = substr($str, 0, $dotIndex);
  }
  if ($str === 'index') return 'Dashboard';
  return ucwords($str);
}
