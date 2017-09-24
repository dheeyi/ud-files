<?php

require __DIR__ . '/../vendor/autoload.php';

use UDFiles\App\App;
use UDFiles\FileManager\File;

/**
 * Initialize the App
 * Basic Example Usage
 * Default parameters must be declared (settings.php)
 */
$settings = require __DIR__ . '/../src/settings.php';
$app = new App($settings);

/**
 * Create an instance of class File
 */
$file = new File($_FILES['file']);

/**
 * Default validations are disabled ['validateExtension' => false, 'validateSize' => false, 'size' => '0'];
 * Default Extensions ['jpeg', 'jpg', 'png', 'pdf', 'txt'];
 *
 * If we want to add a new extension
 * $file->addExtension('png'); or $file->setExtensions(['pdf', 'jpg']);
 */
$file->setValidate(['validateExtension' => true, 'validateSize' => true, 'size' => 100000]);

//Set the directory where files are uploaded
$file->setPathUpload($app->getSetting('upload_path'));


//Upload File
$file->uploadFile($file->getFileName());

//Move de file to other directory
$file->moveFile($file->getFileName(), '/opt/goo/UDFiles/classes');

//Set new directory where files are uploaded
$file->setPathUpload('/opt/goo/UDFiles/classes');

//Rename File
$file->renameFile($file->getFileName(), '/opt/goo/UDFiles/classes/newname.pdf');

//Download File
$file->downloadFile($file->getFileName());

//Download File Inline
$file->downloadFileInline($file->getFileName(), 'application/pdf', true, '/opt/goo/UDFiles/classes');

//Delete File
$file->deleteFile($file->getFileName());

//Move File
$file->moveFile($file->getFileName(), '/opt/goo/UDFiles/classes');

//Delete File (send new path directory)
$file->deleteFile($file->getFileName(), '/opt/goo/UDFiles/classes');
?>