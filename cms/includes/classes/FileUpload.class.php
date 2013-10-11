<?php
/**
 * file upload class
 */

class FileUpload 
 {
  public $upload;
  public $uploadSize;
  public $uploadInfo;
  public $uploadFileName;
  public $uploadDir;
  public $tempFile = false;
  public $maxAcceptedFilesize = 5000;
  public $fileTooLarge = false;
  public $isImage = false;
  public $imageWidth;
  public $imageHeight;
  public $imageType;
  public $error = false;
  public $uploadError = false;
  public $fileEmpty = false;
  public $fileError = false;
  public $invalidFileFormat = false;
  public $fileNameInvalid = false;
  public $fileExtensionInvalid = false;
  public $fileExists = false; 
  public $unableToCompress = false;
  public $copyError = false;

  public function __construct($upload, $uploadDir)
   {
    $this->upload = $upload;
    $this->uploadDir = $uploadDir;
    
    if($upload['error']) 
     {
      $this->error = true;
     }
    elseif($upload['size']==0)
     {
      $this->error = true;
      #$this->fileError = true;
      $this->fileEmpty = true;
     }
    elseif($upload['size']>$this->maxAcceptedFilesize*1000)
     {
      $this->error = true;
      #$this->fileError = true;
      $this->fileTooLarge = true;
     }
    
    if($image=getimagesize($upload['tmp_name']))
     {
      $this->isImage = true;
      $this->imageWidth = $image[0];
      $this->imageHeight = $image[1];
      if($image[2]==1) $this->imageType = 'gif';
      if($image[2]==2) $this->imageType = 'jpeg';
      if($image[2]==3) $this->imageType = 'png';
     }
    
    if(!preg_match('/^[a-zA-Z0-9._\-]+$/', $this->uploadFileName) || mb_substr($this->uploadFileName, 0, 1)=='_')
       {
        #$this->error = true;
        #$this->fileError = true;
        $this->fileNameInvalid = true;
       }      
      if(file_exists($this->uploadDir.$this->uploadFileName))
       {
        #$this->fileError = true;
        $this->fileExists = true;
       }
    
      if(!$this->fileError)
       {
        $tempFileName = uniqid(rand()).'.tmp';
        if(move_uploaded_file($this->upload['tmp_name'],$this->uploadDir.$tempFileName))
         {
          $this->tempFile = $tempFileName;
         }
        else
         {
          $this->uploadError = true;
         }
       }
   }
   
  /**
   * saves the uploaded file
   *
   * @param ...
   */
  public function saveFile($filename='')
   {
    if(empty($filename))
     {
      if($this->fileNameInvalid) return false;
      $filename = $this->uploadFileName;
     }
    if(copy($this->uploadDir.$this->tempFile, $this->uploadDir.$filename)) return true;
    else return false;
   } 

  /**
   * modifies and saves the uploaded image
   *
   * @param ...
   */
  public function saveModifiedImage($width, $height, $compression, $filename='')
   {
    if(empty($filename))
     {
      if($this->fileNameInvalid) return false;
      $filename = $this->uploadFileName;
     }
    if($this->_resize_image($this->uploadDir.$this->tempFile, $this->uploadDir.$filename, $width, $height, $compression)) return true;
    else return false;
   } 

/**
 * resizes uploaded images 
 * 
 * @param string $uploaded_file : uploaded file
 * @param string $file : destination file 
 * @param int $new_width : new width
 * @param int $new_height : new height
 * @param int $compression : compression rate
 * @return bool
 */ 
private function _resize_image($uploaded_file, $file, $new_width, $new_height, $compression=80)
 {
  if(file_exists($file))
   {
    #@chmod($file, 0777);
    @unlink($file);
   }
  #$image_info = getimagesize($uploaded_file);
  if(!$this->isImage || empty($this->imageType)) $error = true;
  if(empty($error))
  {
  if($this->imageType=='gif')
   {
    $current_image = @imagecreatefromgif($uploaded_file) or $error = true;
    if(empty($error)) $new_image = @imagecreate($new_width,$new_height) or $error = true;
    if(empty($error)) @imagecopyresampled($new_image,$current_image,0,0,0,0,$new_width,$new_height,$this->imageWidth,$this->imageWidth) or $error=true;
    if(empty($error)) @imagegif($new_image, $file) or $error = true;
   }
  elseif($this->imageType=='jpeg')
   {
    $current_image = @imagecreatefromjpeg($uploaded_file) or $error = true;
    if(empty($error)) $new_image=@imagecreatetruecolor($new_width,$new_height) or $error = true;
    if(empty($error)) @imagecopyresampled($new_image,$current_image,0,0,0,0,$new_width,$new_height,$this->imageWidth,$this->imageHeight) or $error = true;
    if(empty($error)) @imagejpeg($new_image, $file, $compression) or $error = true;
   }
  elseif($this->imageType=='png')
   {
    $current_image = @imagecreatefrompng($uploaded_file) or $error = true;
    if(empty($error)) $new_image=@imagecreatetruecolor($new_width,$new_height) or $error = true;
    if(empty($error)) @imagecopyresampled($new_image,$current_image,0,0,0,0,$new_width,$new_height,$this->imageWidth,$this->imageHeight) or $error = true;
    if(empty($error)) @imagepng($new_image, $file) or $error = $true;
   }
  }
  if(empty($error)) return true;
  else return false;
 }

  function __destruct()
   {
    if($this->tempFile)
     {
      unlink($this->uploadDir.$this->tempFile);
     }
   }
 }
?>
