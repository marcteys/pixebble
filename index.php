<!doctype html>
<html>
    <head>
        <title>Test</title>    
        <style>
 
        </style>

        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="lib/js/ditherjs.js"></script>
        <script src="lib/js/colors.js"></script>
        <script src="lib/js/jquery.ditherjs.js"></script>

        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <script src="lib/js/dropzone/dropzone.min.js"></script>



    </head>
    <body>

    <div class="content">
        
            <div class="sidebar">
        <div class="logo">
            <h1><strong>Pixe</strong>ble</h1>  
        </div>
        <div class="settings">
            <h4>Settings</h4>
        </div>

    </div>

    <div class="container">
          <form action="upload.php" class="dropzone"></form>
        <div class="watchzone">
            <div class="watch pog" data-title="pog" data-thumbnail-width="144" data-thumbnail-height="168">
                <img src="assets/img/pog.png">
                <div class="shadow"></div>
                <div class="imagezone"></div>
            </div>
            <div class="watch ptr active" data-title="ptr" data-thumbnail-width="180" data-thumbnail-height="180">
              <img src="assets/img/ptr.png">
                <div class="shadow"></div>
                <div class="imagezone dropzone-previews"></div>
            </div>
             <div class="watch pt" data-title="pt" data-thumbnail-width="144" data-thumbnail-height="168">
                    <img src="assets/img/pt.png">
                    <div class="shadow"></div>
                    <div class="imagezone"></div>
            </div>
        </div>
    </div>
    <img class="dither" id="target" src="tests/jpg.jpg" /> 
    </div>



        <script>

//http://www.dropzonejs.com/
Dropzone.autoDiscover = false;

$(document).ready(function() {

var activeWatch = $('.ptr.active');

    var options = {
        previewTemplate : '<div class="dz-image-preview"><img data-dz-thumbnail src="" /></div>',
        previewsContainer : '.dropzone-previews',
        thumbnailWidth : 180,
        thumbnailHeight : 180,
        maxFilesize : 1,
        uploadMultiple : false,
        parallelUploads : 1,
        clickable : false,
        autoProcessQueue:false,
        dictDefaultMessage : "Drop ici mec",
        dictMaxFilesExceeded : "zf",
        accept: function(file, done) {
            console.log(file);
            console.log(requireImageSize(activeWatch).w );
            console.log(file.getWebkitRelativePath);
            if(file.width != requireImageSize(activeWatch).w || file.height != requireImageSize(activeWatch).h) {
            //  this.removeFile(file);
              console.log("cancel");
               done("Image too small.");
            }
            else {
                done();
            }
        },
        resize: function(file) {
        var resizeInfo = {
            srcX: 0,
            srcY: 0,
            trgX: 0,
            trgY: 0,
            srcWidth: file.width,
            srcHeight: file.height,
            trgWidth: this.options.thumbnailWidth,
            trgHeight: this.options.thumbnailHeight
        };

        return resizeInfo;
    }


    };
    var myDropzone = new Dropzone(".dropzone", options);

    myDropzone.on("drop", function(file) {
        $('.dropzone').css({"z-index": "3" });
    });

    myDropzone.on("dragenter", function() {
        console.log("Drag enter");
        $('.dropzone').css({"z-index": "10" });
        activeWatch.find('.imagezone').addClass('active');
    });

    myDropzone.on("dragleave", function() {
        $('.dropzone').css({"z-index": "3" });
        console.log("Drag leave");
                 activeWatch.find('.imagezone').removeClass('active');
    });


    myDropzone.on("addedfile", function(file, result) { //addedfile or //complete
        console.log("Transfert completed");
         activeWatch.find('.imagezone').removeClass('active');

        var returnedElem = $(file.previewElement);
/*
        if (this.files[1]!=null){
            this.removeFile(this.files[0]);
        }
*/
        if($(myDropzone.previewsContainer).children().length > 1) $(myDropzone.previewsContainer).children().first().remove()

        var options = {
            "step": 1,
            "algorithm": "nearest", // nearest // ordered // atkinson // errorDiffusion
            "className": "dithered",
            "palette": pebbleColors()
        };
        var ditherResult = returnedElem.find('img').ditherJS(options, function(dataUrl) {
            $.ajax({
              type: "POST",
              url: "upload.php",
              data: { 
                 imgBase64: dataUrl
              }
            }).done(function(o) {
              console.log("Server upload Done"); 
            })
        });
    });


     $(".watch").click(function(e) {
        activeWatch.removeClass("active");
        $(this).addClass("active");
        myDropzone.previewsContainer = $(this).find(".imagezone")[0];
        myDropzone.options.thumbnailWidth = requireImageSize($(this)).w;
        myDropzone.options.thumbnailHeight = requireImageSize($(this)).h;
        activeWatch = $(this);
     });

    $('.watch').mouseenter(function() {
        if($(this).hasClass("active")) {
         $('.dropzone').css({"pointer-events": "none" });
        }
        myDropzone.previewsContainer.clickable = ".sidebar";
    });

    $('.watch').mouseleave(function() {
         $('.dropzone').css({"pointer-events": "auto" });
    });

    function requireImageSize(elem) {
        return { w : elem.data("thumbnail-width"), h: elem.data("thumbnail-height")};
    }


});






        </script>
    </body>
</html>
