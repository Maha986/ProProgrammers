


<?php
require "_dbconnect.php";

$id=$_GET['id'];
$down=$conn->prepare("SELECT `Title` FROM `books` WHERE `Sno`=$id");
        $down->execute();
        $downres=$down->get_result();
        $rnum=mysqli_num_rows($downres);
        if($rnum>0)
        {
            while($row=mysqli_fetch_assoc($downres))
            {
                
                $name=$row['Title'];
                $remoteURL="uploads/$name";
                $extension = pathinfo($title, PATHINFO_EXTENSION); //The pathinfo() function returns information about a file path.
                if($extension=="pdf")
                {
                    header("Content-Type: application/pdf");
                }
                else
                {
                    header("Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                }
                header("Content-Transfer-Encoding: binary");
                //In a regular HTTP response, the Content-Disposition response header is a header indicating if the content is expected to be displayed inline in the browser, that is, as a Web page or as part of a Web page, or as an attachment, that is downloaded and saved locally.
                //indicating it should be downloaded; most browsers presenting a 'Save as' dialog, prefilled with the value of the filename parameters if present
                header("Content-Disposition: attachment; filename=".basename($name));
                //The ob_end_clean() function deletes the topmost output buffer and all of its contents without sending anything to the browser.
                ob_end_clean();
                //The readfile() function reads a file and writes it to the output buffer.
                readfile($remoteURL);
                exit;
            }
        }

?>