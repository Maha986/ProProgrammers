<!DOCTYPE html>

<html>
<head>
  <style>
    p
    {
      font-size: 1.6rem;
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
img
{
  width:39%;
}
img#loading_image {
    width: 120px;
    margin: 0px auto;
    display: block;
    display: none;
}
@media screen and (max-width:750px) {
  section
  {
    flex-direction: column-reverse;
    align-items: center;
  }
  img
  {
    width: 97%;
  }
  div
{
  width: 97%;
}
}
  </style>
</head>
<body>

<section style="display:flex;justify-content:space-around;">
<div>
  <p>Select video to upload:</p>
  <input type="file" name="fileToUpload" id="fileToUpload" accept="video/mp4, video/webm, video/x-matroska">
  <input type="submit" id="uploadbtn" value="Upload Video" name="submit">
<img src="img/spinner.gif" id="loading_image" alt="">

</div>
<img src="img/videoscreen.jpg" alt="">
</section>
<p id="msg"></p>

<script src="js/jquery-3.6.0.min.js"></script>
<script>
  $('#uploadbtn').on('click', function() {
    // e.preventDefault();
    $('#msg').text("");
    $('#loading_image').css("display","block");
    var file_data = $('#fileToUpload').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    // alert(form_data);                             
    $.ajax({
        url: 'videoupload.php', // <-- point to server-side PHP script 
        type: 'POST',
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
          $('#msg').text(data); 
          $('#loading_image').css("display","none");

        }
     });
});
</script>
</body>
</html>
