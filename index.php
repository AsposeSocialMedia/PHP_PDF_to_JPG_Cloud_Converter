<?php

// Include the SDK files that we need here
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Common/AsposeApp.php");
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Common/Product.php");
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Common/Utils.php");
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Exception/AsposeCloudException.php");
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Storage/Folder.php");
require_once(dirname(__FILE__)."/Aspose_Cloud_SDK_For_PHP/src/Aspose/Cloud/Pdf/Converter.php");

//The appSID and appKey are used for authentication
Aspose\Cloud\Common\AsposeApp::$appSID = "..."; 
Aspose\Cloud\Common\AsposeApp::$appKey = "..."; 
// The output location is the directory where we hold the converted images
// It should be have writable permissions. There should be a / at the end of this.
Aspose\Cloud\Common\AsposeApp::$outPutLocation = getcwd() . "/Output/";


$input = "Sample.pdf";
$format = "jpeg";
$page = 1;

// We shall use the Folder and Converter component of SDK
$folder = new Aspose\Cloud\Storage\Folder();
$converter = new Aspose\Cloud\Pdf\Converter($input);

try {

  // Upload the $input file to Aspose Cloud Storage
  $folder->UploadFile($input, "");

  // Convert $page into specified $format and save the result in $output file
  $output = $converter->ConvertToImage($page, $format);

  // Tell the web browser that the PHP script is about to send a JPG image
  header("image/jpeg");

  // Send the contents our $output file to the browser
  echo file_get_contents($output);

  // Delete the generated $output file. We don't need it anymore
  unlink($output);

  // Delete the uploaded PDF too. We are all done with it.
  // It is a good practice to keep the uploaded document until all operation
  // are complete and the file is no more needed. Uploading the file
  // again on each request will waste time :-)
  $folder->DeleteFile($input);

} catch (Exception $x) {
  // Ooops! let the user know what happened
  echo $x->getMessage();
}
