/**
* jQuery plugin definition
* */
;(function( $ ) {
    $.fn.ditherJS = function(opt, callback) {
            new DitherJS(this.selector,opt, callback);            
        return this;
    };
}( jQuery ));
