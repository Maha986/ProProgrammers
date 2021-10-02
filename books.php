<!DOCTYPE html>

<html>

<head>
  <style>
    p {
      font-size: 1.6rem;
      margin-top: 0px;
    }

    input[type="submit"] {
      display: block;
      padding: 10px;
      color: white;
      background: #1eb2a6;
      border: none;
      border-radius: 9px;
      cursor: pointer;
      outline: none;
      margin: 15px 0px;
    }

    input#fileToUpload {
      font-size: 0.9rem;
    }

    label {
      display: block;
      margin: 10px 0px;
      font-size: 1.2rem;
    }

    img {
      width: 39%;
    }

    img#loading_image {
      width: 120px;
      margin: 0px auto;
      display: block;
      display: none;
    }

    @media screen and (max-width:750px) {
      section {
        flex-direction: column-reverse;
        align-items: center;
      }

      img {
        width: 97%;
      }

      div {
        width: 97%;
      }
    }
  </style>
</head>

<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js" integrity="sha512-UqYzmySEh6DXh20njgxWoxDvuA4qqM8FmKWTkRvkYsg7LjzjscbMHj06zbt3oC6kP2Oa7Qow6v/lGLeMywbvQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <section style="display:flex;justify-content:space-around;">
    <div>
      <p>Select book to upload:</p>
      <form method="POST" id="bookform" enctype="multipart/form-data">
  <input type="file" name="file" id="file" accept=".pdf,.docx,.doc">
  <label for="catogory" id="cat">Catogory</label>
                    <input type="radio" name="catogory" value="Book" required> Book
                    <input type="radio" name="catogory" value="Article" required> Article
                    <br>
                    <label for="lang">Language</label>
                    <input type="text" name="lang" id="lang" list="language" required>
                    <datalist id="language">
                      <option value="Java"></option>
                      <option value="C++"></option>
                      <option value="C"></option>
                      <option value="C-Sharp"></option>
                      <option value="Python"></option>
                      <option value="Php"></option>
                      <option value="HTML"></option>
                      <option value="CSS"></option>
                      <option value="JavaScript"></option>
                      <option value="SQL"></option>
                    </datalist>

  <input type="submit" id="uploadbtn" value="Upload Book" name="submit">
</form>
<img src="img/spinner.gif" id="loading_image" alt="">

</div>
<canvas id="the-canvas" style="border: 1px solid black; direction: ltr;"></canvas>
    <!-- <img src="img/books.jpg" alt=""> -->
  </section>
  <p id="msg"></p>

  <script src="js/jquery-3.6.0.min.js"></script>
  <script>
    $('#bookform').on('submit', function (e) {
      e.preventDefault();
      $('#msg').text("");
      $('#loading_image').css("display", "block");
      $.ajax({
        url: 'bookupload.php', // <-- point to server-side PHP script 
        type: 'POST',
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: new FormData(this),
        success: function (data) {
          $('#msg').text(data);
          $('#loading_image').css("display", "none");

        }
      });
    });


     // Submit form data via Ajax

      $("#fupForm").on('submit', function(e) {

        e.preventDefault();
        console.log("clock");
        $.ajax({
          url: 'bookupload.php', data: new FormData(this), type: 'POST',

          dataType: 'text', contentType: false, cache: false, processData: false,

          success: function(data) { //console.log(response); $('.statusMsg').html
            console.log(data);
          }

        });

      });

      pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"
  var url = './helloworld.pdf';
var pdf = document.getElementById('file');
    pdf.onchange = function(ev) {
      if (file = document.getElementById('file').files[0]) {
        fileReader = new FileReader();
        fileReader.onload = function(ev) {
          console.log(ev);
          pdfjsLib.getDocument(fileReader.result).promise.then(function getPdfHelloWorld(pdf) {
            //
            // Fetch the first page
            //
            console.log(pdf)
            pdf.getPage(1).then(function getPageHelloWorld(page) {
              var scale = 1.0;
              //var viewport = page.getViewport({scale:scale});

              //
              // Prepare canvas using PDF page dimensions
              //
              var canvas = document.getElementById('the-canvas');
              var context = canvas.getContext('2d');
              canvas.height = 120;
              canvas.width = 230;

var viewport = page.getViewport({scale:canvas.width / page.getViewport({scale:1.0}).width});

              //
              // Render PDF page into canvas context
              //
              var task = page.render({canvasContext: context, viewport: viewport})
              task.promise.then(function(){
                console.log(canvas.toDataURL('image/jpeg'));
                image_data=canvas.toDataURL('image/jpeg');
                filename=document.getElementById('file').value;
                console.log(filename);
                $.ajax({
                  url: '_librarydb.php',
                  type: 'POST',
                  data: {
                    img:image_data,
                    filename:filename,
                    action:"image_creation",
                   
                  },
                  success: function (data) {
                    console.log(data);

                  }
                });
              });
            });
          }, function(error){
            console.log(error);
          });
        };
        fileReader.readAsArrayBuffer(file);
      }
    }
  </script>
</body>

</html>