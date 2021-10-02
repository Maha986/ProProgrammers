// making slideshow 
var slidebox = document.getElementsByClassName('slidebox');
var coursescurrentslideno = 0;
var librarycurrentslideno = 0;
//set up the slider
function leftstyle() 
{
    slidebox[0].style.left = "0%";
    slidebox[1].style.left = "100%";
    slidebox[2].style.left = "0%";
    slidebox[3].style.left = "100%";
    
    $('.firstbtn').css("color","#1eb2a6");
}
leftstyle();  //call at page reload
function first(id)
{
    if(id=="coursesfirstbtn")
    {
        if (coursescurrentslideno != 0) 
        {
            coursescurrentslideno--;
            $('#coursescontainer').css("transform", "translateX(0px)");
            $('#coursesfirstbtn').css("color","#1eb2a6");
            $('#coursessecondbtn').css("color","#a9a6a6");
        }
    }
    else
    {
        if (librarycurrentslideno != 0) 
        {
            librarycurrentslideno--;
            $('#librarycontainer').css("transform", "translateX(0px)");
            $('#libraryfirstbtn').css("color","#1eb2a6");
            $('#librarysecondbtn').css("color","#a9a6a6");
        }
    }
}
function second(id)
{
    var slideboxwidth = slidebox[0].clientWidth;
    console.log(slideboxwidth);
   //  console.log(slideboxwidth);
    if(id=="coursessecondbtn")
    {
        if (coursescurrentslideno != 1) {
            coursescurrentslideno++;
            $('#coursescontainer').css(
                {
                    transform: 'translateX(-' + slideboxwidth + 'px)'
                }
            );
            $('#coursessecondbtn').css("color","#1eb2a6");
            $('#coursesfirstbtn').css("color","#a9a6a6");
        }
    }
    else
    {
        if (librarycurrentslideno != 1) {
            librarycurrentslideno++;
            $('#librarycontainer').css(
                {
                    transform: 'translateX(-' + slideboxwidth + 'px)'
                }
            );
            $('#librarysecondbtn').css("color","#1eb2a6");
            $('#libraryfirstbtn').css("color","#a9a6a6");
        }
    }
}

function closeError() {
    $('#errormsg').css("display", "none");
}