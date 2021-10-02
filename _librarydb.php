<?php
require '_dbconnect.php';
// require '_googledriveconnect.php';

$action = $_POST['action'];

if ( $action == 'pdfdisplay' )
 {
    $id = $_POST['id'];

    $pdfselect = $conn->prepare( "SELECT `Title` FROM `books` WHERE `Sno`=$id" );
    $pdfselect->execute();
    $pdfresult = $pdfselect->get_result();
    $rnum = mysqli_num_rows( $pdfresult );
    if ( $rnum>0 )
 {
        while( $row = mysqli_fetch_assoc( $pdfresult ) )
 {
            $title = $row['Title'];
            echo '<iframe id="pdfview" src="uploads/'.$title.'" width="100%" height="680px" style="background:url(img/spinner.gif) center center no-repeat; background-size:170px;"></iframe>';
            // echo "<embed type='application/pdf' src='uploads/$title'>";
            // echo '<iframe src="https://docs.google.com/gview?url=http://ocalhost/Web_Engineering/webproj/library.php/intro.doc&embedded=true"></iframe>';
            echo '<p id="pdfId" style="display:none;">'.$id.'</p>';
        }
    }
}
if ( $action == 'search' )
 {
    $searchValue = $_POST['search'];
    
    if ( $searchValue == '' )
    {
        echo "1";
    } 
    else 
    {
        $pieces=explode(" ",$searchValue);
        foreach($pieces as $i)
        {
            $sqlselect = $conn->prepare( "SELECT *
            FROM books WHERE `Language` LIKE '%$i%' OR `Title` LIKE '%$i%'");
            $sqlselect->execute();
            $sqlsresult = $sqlselect->get_result();
            $rsnum = mysqli_num_rows( $sqlsresult );
            if ( $rsnum>0 )
            {
        
                while( $srow = mysqli_fetch_assoc( $sqlsresult ) )
                {
                    $divId = $srow['Sno'];
                    $title = $srow['Title'];
                    $fileid=$srow['FileId'];
                    $without_extension = pathinfo( $title, PATHINFO_FILENAME );
                    // $res = $service->files->get( $fileid, ['fields' => 'name,thumbnailLink'] );
                    // $thumbnailLink = str_replace( '=s220', '=s1000', $res->getThumbnailLink() );
                    // $name = $res->getName();
                    // $image = ( file_get_contents( $thumbnailLink ) );
                    // <img src='data:image/jpeg;base64," . base64_encode($image) . "' width='329px' height='290px'  style='object-fit: cover;'>
                    echo "<div class='booksdiv' id=$divId onclick='pdfDisplay(this.id)'><img src='uploads/$without_extension.png' width='329px' height='290px'  style='object-fit: cover;'><p class='insidepadding'>
                        <i class='fal fa-book'></i>".$without_extension."'</p></div>";
            
                }
      

            }

        }



        
    }
}

if($action=="image_creation")
{
    $data=$_POST["img"];
    // $filename=basename($_POST["filename"]);
    $filename=pathinfo($_POST["filename"], PATHINFO_FILENAME);
    echo $filename;
    list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
file_put_contents("uploads/".$filename.".png", $data);
}
$conn->close();
?>