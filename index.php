<!doctype html>
<html>
    <head>
        <title>Test</title>    
        <style>
            .dither {
                visibility:hidden;
            }

            .hiddenCanvas{

            }    
            #drop {
                height: 100px;
                width : 100px;
                background-color: red;
            }
        </style>

        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="lib/js/ditherjs.js"></script>
        <script src="lib/js/colors.js"></script>
        <script src="lib/js/jquery.ditherjs.js"></script>

        <link rel="stylesheet" type="text/css" href="lib/js/dropzone/dropzone.min.css">
        <script src="lib/js/dropzone/dropzone.min.js"></script>



    </head>
    <body>
      <img class="dither" id="target" src="tests/jpg.jpg" /> 

        <form action="upload.php" class="dropzone"></form>



        <script>

//http://www.dropzonejs.com/
Dropzone.autoDiscover = false;
$(document).ready(function() {
    console.log('ready');
    
       var options = {
            "step": 1,
            "algorithm": "nearest", //ordered // atkinson // errorDiffusion
            "className": "dithered",
            "palette": pebbleColors()
        };
     var ditherResult = $('.dither').ditherJS(options, postAjax);
});

$(function() {
    var myDropzone = new Dropzone(".dropzone");
    myDropzone.on("complete", function(file, result) {
        console.log("complete");
        var returnedElem = $(file.previewElement);
        var options = {
            "step": 1,
            "algorithm": "nearest", // nearest // ordered // atkinson // errorDiffusion
            "className": "dithered",
            "palette": pebbleColors()
        };
        var ditherResult = returnedElem.find('img').ditherJS(options, postAjax);
    });
})

            function postAjax(dataUrl) {
                console.log(dataUrl);


                $.ajax({
                  type: "POST",
                  url: "upload.php",
                  data: { 
                     imgBase64: dataUrl
                  }
                }).done(function(o) {
                  console.log(o); 
                  // If you want the file to be visible in the browser 
                  // - please modify the callback in javascript. All you
                  // need is to return the url to the file, you just saved 
                  // and than put the image in your browser.
                })
            }





        </script>
    </body>
</html>
