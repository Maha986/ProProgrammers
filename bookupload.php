
<?php
    require_once "_dbconnect.php";
    require_once 'vendor/autoload.php';
    $cat=$_POST["catogory"];
    $lang=$_POST["lang"];
    if(empty($_FILES["file"]["name"]))
    {
      echo "Please select the file.";
      return false;
    }


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
      echo"Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["file"]["size"] > 55000000000000) {
      echo"Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo"Sorry, your file was not uploaded.";
    
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $filename=htmlspecialchars( basename( $_FILES["file"]["name"]));
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if($extension!="pdf")
        {
          $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
          $contents=$objReader->load("uploads/".$filename);
          
          $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
          
          $renderLibrary="TCPDF";
          $renderLibraryPath=''.$renderLibrary;
          if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibrary)){
            die("Provide Render Library And Path");
          }
          $renderLibraryPath=''.$renderLibrary;
          $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
          $t=pathinfo( basename($_FILES["file"]["name"]), PATHINFO_FILENAME );
          $objWriter->save("uploads/$t.pdf");
          unlink("uploads/".$filename);
  
          $filename=$t.".pdf";
        }
        
        $insertfilename=$conn->prepare("INSERT INTO `books` (Title,Catogory,Language) VALUES (?,?,?)");
        $insertfilename->bind_param('sss',$filename,$cat,$lang);
        $insertfilename->execute();

        echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
      } else {
        echo"Sorry, there was an error uploading your file.";
    
      }
    }
?>
