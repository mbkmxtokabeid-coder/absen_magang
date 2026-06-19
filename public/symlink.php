<?php
  $targetFolder = __DIR__ .'/laravel/storage/app/public';
  $linkFolder = __DIR__ .'/absensi/storage';
  symlink($targetFolder,$linkFolder);
  echo 'Symlink process successfully completed';
?>