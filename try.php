
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js" integrity="sha512-UqYzmySEh6DXh20njgxWoxDvuA4qqM8FmKWTkRvkYsg7LjzjscbMHj06zbt3oC6kP2Oa7Qow6v/lGLeMywbvQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script id="script">
  //
  // If absolute pdf from the remote server is provided, configure the CORS
  // header on that server.
  //
  //
  // The workerSrc property shall be specified.
  //
  pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"
  var pdf = 'uploads/Datapath.pdf';
// var pdf = document.getElementById('pdf');
    // pdf.onchange = function(ev) {
    //   if (file = document.getElementById('pdf').files[0]) {
        document.onload=function(){
            fileReader = new FileReader();
        fileReader.onload = function(ev) {
        //   console.log(ev);
          pdfjsLib.getDocument(fileReader.result).promise.then(function getPdfHelloWorld(pdf) {
            //
            // Fetch the first page
            //
            // console.log(pdf)
            pdf.getPage(1).then(function getPageHelloWorld(page) {
              var scale = 1.0;
              var viewport = page.getViewport({scale:scale});

              //
              // Prepare canvas using PDF page dimensions
              //
              var canvas = document.getElementById('the-canvas');
              var context = canvas.getContext('2d');
              canvas.height = 1000;
              canvas.width = 500;

              //
              // Render PDF page into canvas context
              //
              var task = page.render({canvasContext: context, viewport: viewport})
              task.promise.then(function(){
                console.log(canvas.toDataURL('image/jpeg'));
                $image_data=canvas.toDataURL('image/jpeg');
                <?php echo "<img src='data:image/jpeg;base64," . base64_encode($image_data) . "' width='329px' height='290px'  style='object-fit: cover;'>" ?>
              });
            });
          }, function(error){
            console.log(error);
          });
        };
        }
        
        // fileReader.readAsArrayBuffer(file);
    //   }
    // }
</script>
</body>
</html>