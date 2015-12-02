<!doctype html>
<html>
    <head>
        <title>Test</title>    
        <style>
            .dither {
                visibility:hidden;
                width:144px
            }

            .hiddenCanvas{

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
        <img class="dither" id="target" src="tests/parrot-zoo-small.jpg" />

        <form action="upload.php" class="drop"></form>



        <script>

        $( document ).ready(function() {
            console.log('ready');

            var options = {
                "step":1,
                "algorithm": "ordered",
                "className": "dithered",
                "palette" : pebbleColors()
            };

            var ditherResult = $('.dither').ditherJS(options, PostAjax);

            function PostAjax(dataUrl) {
                console.log(dataUrl);

/*
                $.ajax({
                  type: "POST",
                  url: "imageupload.php",
                  data: { 
                     imgBase64: dataUrl
                  }
                }).done(function(o) {
                  console.log(o); 
                  // If you want the file to be visible in the browser 
                  // - please modify the callback in javascript. All you
                  // need is to return the url to the file, you just saved 
                  // and than put the image in your browser.
                })*/
            }

            var dropOptions = 
            $('.drop').dropzone( {url:"uploads")




        });

        


        </script>
    </body>
</html>
