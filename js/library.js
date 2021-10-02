// modal opening and closing
$('#uploadbtn').click(() => {
    $('#upload-modal').css("display", "block");
    $('body').css("position","fixed");
    $('body').css("width","100vw");
    // $('#pdf-viewer-modal').css("display","none");
});



$('#pdf-viewer-close').click(() => {
    $("#pdf-viewer-modal").css("display", "none");
    $('#pdfview').prop('src', "about:blank");
    
});
$('#upload-close').click(() => {
    $("#upload-modal").css("display", "none");
    $('body').css("position","unset");
    $('body').css("width","unset");
    location.reload();
});

function pdfDisplay(id) {
    $('#pdf-viewer-modal').css("display", "block");
    var action = 'pdfdisplay';
    $.ajax({
        url: "_librarydb.php",
        type: 'POST',
        data: {
            action: action,
            id: id,
        },
        dataType: "html",
        success: function (data) {
            $('#pdfviewer').html(data);
        }

    });

}

function download() {
    var sno = $('#pdfId').text();
    console.log(sno);
    var link = "download.php?id=" + sno;
    console.log(link);
    $('#move').attr("href", link);
    $('#move')[0].click();
}

$('#langMenu').children().on("click", () => {
    showitem("book");
})

function showitem(catogory) {
    if (catogory == "article") {
        $('#outerBookDiv').fadeOut(1000, "swing");
        $('#bookDiv').fadeOut(1000, "swing");
        $('#articleDiv').fadeIn(1000, "swing");
        $('#articleDiv').css("display", "flex");
    }
    else if (catogory == "book") {
        $('#outerBookDiv').fadeOut(1000, "swing");
        $('#articleDiv').fadeOut(1000, "swing");
        $('#bookDiv').fadeIn(1000, "swing");
        $('#bookDiv').css("display", "flex");
    }
    else {
        $('#articleDiv').fadeOut(1000, "swing");
        $('#bookDiv').fadeOut(1000, "swing");
        $('#outerBookDiv').fadeIn(1000, "swing");
        $('#outerBookDiv').css("display", "flex");
    }
}

var sl = window.matchMedia("(max-width:778px");
uploadbutton(sl);
sl.addListener(uploadbutton);
function uploadbutton(sl) {
    if (sl.matches) {

        $('#uploadlink').html('<i class="fas fa-cloud-upload-alt"></i>');
        $('#uploadbtn').css("padding", "7px 0px");

    }
}


var sl1 = window.matchMedia("(min-width:779px)");
hideicon(sl1);
sl1.addListener(hideicon);
function hideicon(sl1) {
    if (sl1.matches) {
        $('#uploadlink').html('Upload Books');
        $('#uploadbtn').css("padding", "12px");
    }
}

$('#catalogsearching').click(()=>{
    
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

