<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProProgrammers| Library</title>
    <link rel="stylesheet" href="css/library.css">
</head>

<body>
    <?php
    include "nav.php";

    include "signup.php";
    include "login.php";
    require "_dbconnect.php";
    ?>



    <section id="libraysect">
        <div id="searchbar">
            <input type="text" name="searchcatalog" id="searchcatalog" required>
            <button id="catalogsearching"><i class="fas fa-search"></i></button>
        </div>

        <nav id="librarybar">
            <!-- add icon along with books articles -->
            <ul>
                <li>
                    <button class="lib-btn" onclick="showitem('main')">Library Home</button>
                </li>
                <li>
                    <button class="lib-btn" id="books" onclick="showitem('book')">Books</button>
                    <ul id="langMenu"></ul>
                </li>
                <li>
                    <button class="lib-btn" onclick="showitem('article')">Articles</button>
                </li>
                <li>

                    <button id="uploadbtn" title="Upload"><a id="uploadlink" href="books.php" target="right_side">Upload Books</a></button>
                </li>
            </ul>

        </nav>

        <div class="upload-material-modal" id="upload-modal">
            <div class="inner-modal">
                <span class="close-modal" id="upload-close">&times;</span>
                <div>
                    <iframe id="right_side" name="right_side" src="" width="100%" height="350px" frameBorder="0"></iframe>
                </div>
            </div>
        </div>

        <!-- display 12 document at random -->
        <div id="outerBookDiv" class="documentsdiv">
            <?php
            //two dynamic tables are created first by name r1 having all data from book
            //second table name is r1 which has one column named id having rand()*max value of sno
            //did -12 from max so even if random has to be chosen the same no (as resulted from max-12) we always has 12 files to show
            //rand()*n means that any random no less than n
            //join the two tables where the sno of first table is greater or equal than id of 2nd table 
            //after joining result will be first book table complete and then 2nd ccomplete table which has just one column
            //because of where condition only those records will be fetched where in books table sno is greater than id of r2
            $sqlselect = $conn->prepare("SELECT *
              FROM books AS r1 JOIN
                  (SELECT (RAND() *
                                (SELECT MAX(Sno)-12
                                   FROM books)) AS id)
                   AS r2
            WHERE r1.Sno >= r2.id
            ORDER BY r1.Sno ASC
            LIMIT 12");
            $sqlselect->execute();
            $sqlresult = $sqlselect->get_result();
            $rnum = mysqli_num_rows($sqlresult);
            if ($rnum > 0) {
                while ($row = mysqli_fetch_assoc($sqlresult)) {

                    // $image_data = $row['Preview'];
                    $divId = $row['Sno'];
                    $title = $row['Title'];
                    $without_extension = pathinfo($title, PATHINFO_FILENAME);

                    // <img src='data:image/jpeg;base64," . base64_encode($image_data) . "' width='329px' height='290px'  style='object-fit: cover;'>
                    echo "<div class='booksdiv' id=$divId onclick='pdfDisplay(this.id)'><img src='uploads/$without_extension.png' width='329px' height='290px'><p class='insidepadding'>
                <i class='fal fa-book'></i>" . $without_extension . "</p></div>";
                }
            }
            ?>
        </div>

        <!-- articles section -->
        <div id="articleDiv" class="documentsdiv">
            <?php
            $sqlselect = $conn->prepare("SELECT *
              FROM books WHERE `catogory`='Article'");
            $sqlselect->execute();
            $sqlresult = $sqlselect->get_result();
            $rnum = mysqli_num_rows($sqlresult);
            if ($rnum > 0) {
                while ($row = mysqli_fetch_assoc($sqlresult)) {

                    // $image_data = $row['Preview'];
                    $divId = $row['Sno'];
                    $title = $row['Title'];
                    $without_extension = pathinfo($title, PATHINFO_FILENAME);
                    
                    echo "<div class='booksdiv' id=$divId onclick='pdfDisplay(this.id)'><img src='uploads/$without_extension.png' width='329px' height='290px'><p class='insidepadding'>
                <i class='fal fa-book'></i>" . $without_extension . "</p></div>";
                }
            }
            ?>

        </div>


        <!-- books section -->
        <div id="bookDiv" class="documentsdiv">
            <?php
            $sqlselect = $conn->prepare("SELECT *
              FROM books WHERE `catogory`='Book'");
            $sqlselect->execute();
            $sqlresult = $sqlselect->get_result();
            $rnum = mysqli_num_rows($sqlresult);
            if ($rnum > 0) {
                while ($row = mysqli_fetch_assoc($sqlresult)) {

                    // $image_data = $row['Preview'];
                    $divId = $row['Sno'];
                    $title = $row['Title'];
                    $lang = $row['Language'];
                    $without_extension = pathinfo($title, PATHINFO_FILENAME);
                    echo "<script>
                    if(!$('#" . $lang . "').length)
                    {
                       
                        $('#bookDiv').append(`<div><h1 id='h-$lang'>".$lang."</h1></div><div class='documentsdiv' id=$lang style='margin:0px 10px 12px 10px;'></div></div>`);
                        $('#langMenu').append(`<li><a href='#h-".$lang."'>".$lang."</a></li>`);
                    }
                    </script>";
                    echo "<script>
                    $('#" . $lang . "').append(`<div class='booksdiv' id=$divId onclick='pdfDisplay(this.id)'><img src='uploads/$without_extension.png' width='329px' height='290px'><p class='insidepadding'>
                    <i class='fal fa-book'></i>" . $without_extension . "</p></div>`);
                   
                    </script>";
                    // <img src='data:image/jpeg;base64," . base64_encode($image_data) . "' width='329px' height='290px'  style='object-fit: cover;'>
                 } 
             }
             ?>
     </div>

        <div id="searchDiv" class="documentsdiv">
             <?php
                
             ?>
        </div>

        <div id="pdf-viewer-modal">
            <div class="inner-modal">
                <span class="close-modal" id="pdf-viewer-close">&times;</span>
                <span id="downloadIcon" title="Download file" onclick="download()"><i class="fas fa-download"></i></span>
                <a id="move" href="" style="display:none;"></a>
                <div id="pdfviewer"></div>
            </div>
        </div>

    </section>
    <?php
    include "footer.php";
    ?>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/library.js"></script>
    <script>
        $('#catalogsearching').click(()=>{
            // document.cookie = "fesr=John Doe";
    var searchValue=$("#searchcatalog").val();
    var action='search';
    $.ajax({
        url: "_librarydb.php",
        type: 'POST',
        data: {
            action: action,
            search: searchValue,
        },
        dataType: "html",
        success: function (data) {
            $('#searchDiv').html(data);
            if(data!="1")
            {
                $('#articleDiv').fadeOut(1000, "swing");
                $('#bookDiv').fadeOut(1000, "swing");
                $('#outerBookDiv').fadeOut(1000, "swing");
                $('#searchDiv').fadeIn(1000, "swing");
                $('#searchDiv').css("display", "flex"); 
            }
            else
            {
                alert('Please, Enter the search value.');
            }
        }
    });
 

})
    </script>
</body>

</html>