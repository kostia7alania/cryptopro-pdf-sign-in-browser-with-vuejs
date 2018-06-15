/**
 * jquery-watermarker v0.3
 * jQuery Image watermark positioning Plugin
 * @author Francois Mazerolle <fmaz008@gmail.com>
 *
 * Partially based on:
 * jquery.Jcrop.js v0.9.8
 * jQuery Image Cropping Plugin
 * @author Kelly Hallman <khallman@gmail.com>
 * Copyright (c) 2008-2009 Kelly Hallman - released under MIT License {{{
 */  
    $.Watermarker = function (obj, opt) {
        
        var obj = obj,
            opt = opt; 
        if (typeof (obj) !== 'object') obj = $(obj)[0];
        if (typeof (opt) !== 'object') opt = {};

         var defaults = { 
            watermark_img: 'watermark.png',  
            x: null, //CentrГ© par dГ©faut
            y: null, //CentrГ© par dГ©faut
            w: null, //100% par dГ©faut
            h: null, //100% par dГ©faut
            position: null, //CentrГ© par dГ©faut
            onChange: function () {},
            onSelect: function () {}
        };
        var options = defaults;
        setOptions(opt);
        var origimg = $(obj); 
        var $container = $('<div />').width(origimg.width()).height(origimg.height()).css({position: 'relative'}).insertAfter(origimg);
        $container.append(origimg);
        var wcontainer = 
            $('<div />')
          /*.resizable({resize:function (event, ui) {setSubElemSameSizeAsContainer();updateData();},containment: 'parent'})*/
            .draggable({drag:  function (event, ui) {updateData();},containment: 'parent'})
            .css({position: 'absolute'})
            .insertAfter(origimg);
            var $styleContainer = $('<div />').addClass('watermark').css({position: 'absolute','z-index': 1})
        wcontainer.append($styleContainer); 
    
        var waterimg = $('<img />')
            .attr('src', options.watermark_img)
            .addClass('watermark')
            .css({position: 'absolute','z-index': 2})
            .load(function () {watermarkLoaded();});
        wcontainer.append(waterimg); 

        function watermarkLoaded() {
            var middleX = Math.round(origimg.width() / 2 - waterimg.width() / 2);
            var middleY = Math.round(origimg.height() / 2 - waterimg.height() / 2);
            var bottomY = origimg.height() - waterimg.height();
            var rightX = origimg.width() - waterimg.width();
            var posX, posY;
            if (options.x != null && options.y != null) {
                posX = options.x;
                posY = options.y;
            } else { 
                posX = middleX;
                posY = middleY;
            }
 
            wcontainer.css({
                top: posY + 'px',
                left: posX + 'px'
            }); 
            wcontainer.width(options.w == null ? waterimg.width() : options.w);
            wcontainer.height(options.h == null ? waterimg.height() : options.h); 
            setSubElemSameSizeAsContainer(); 
            updateData(); 
        }
        function setOptions(opt) {
            if (typeof (opt) != 'object') opt = {}; 
            options = $.extend(options, opt);
            if (typeof (options.onChange) !== 'function') options.onChange = function () {};
            if (typeof (options.onSelect) !== 'function') options.onSelect = function () {}; 
        };

        function setSubElemSameSizeAsContainer() {
            waterimg.width(wcontainer.width());
            waterimg.height(wcontainer.height());
 
            var bL = removePx($styleContainer.css('borderLeftWidth'));
            var bR = removePx($styleContainer.css('borderRightWidth'));
            var bT = removePx($styleContainer.css('borderTopWidth'));
            var bB = removePx($styleContainer.css('borderBottomWidth'));

            $styleContainer.width(wcontainer.width() - bL - bR);
            $styleContainer.height(wcontainer.height() - bT - bB);
        } 
        function removePx(str) { return parseInt(str.replace('px', '')); } 
        function updateData() {
            var WatermarkPos = getPos(waterimg);
            var ContainerPos = getPos($container);
            options.onChange({
                x: WatermarkPos[0] - ContainerPos[0],
                y: WatermarkPos[1] - ContainerPos[1],
                w: waterimg.width(),
                h: waterimg.height()
            });
        } 
        function getPos(obj) { 
            var pos = $(obj).offset();
            return [pos.left, pos.top];
        };
    };

    $.fn.Watermarker = function (options)  {
        function attachWhenDone(from)  {
            var loadsrc = options.useImg || from.src;
            var img = new Image();
            img.onload = function () {
                $.Watermarker(from, options);
            };
            img.src = loadsrc;
        }; 
        if (typeof (options) !== 'object') options = {}; 
        this.each(function () {
            // If we've already attached to this object
            if ($(this).data('Watermarker')) {
                // The API can be requested this way (undocumented)
                if (options == 'api') return $(this).data('Watermarker');
                // Otherwise, we just reset the options...
                else $(this).data('Watermarker').setOptions(options);
            }
            // If we haven't been attached, preload and attach
            else attachWhenDone(this);
        });  
        // Return "this" so we're chainable a la jQuery plugin-style!
        return this;
    };   