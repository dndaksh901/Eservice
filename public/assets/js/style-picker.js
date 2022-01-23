/*!
 * AdminuxPRO script v1.0.0 (https://www.maxartkiller.com/)
 * Copyright 2019-2019 The Maxartkiller Authors
 * Copyright 2019-2019 Maxartkiller.com
 * Licensed: You must have a valid license purchased only from maxartkiller.com in order to legally use the theme for your project.
 */
'use strict'
$(document).ready(function () {

    $('#wrapperCorner').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('wrapper-square');
            if ($('body').hasClass('header-fixed-top') == true) {
                var headerheight = $('.header-container').outerHeight();
                $('.wrapper').css('padding-top', headerheight);
            } else {
                $('.wrapper').css('padding-top', '0');
            }
        } else {
            $('body').removeClass('wrapper-square');
            if ($('body').hasClass('header-fixed-top') == true) {
                var headerheight = $('.header-container').outerHeight() + 15;
                $('.wrapper').css('padding-top', headerheight);
            } else {
                $('.wrapper').css('padding-top', '15px');
            }
        }
    });
    $('#contentWidth').on('click', function () {
        if ($(this).is(':checked')) {
            $('#main-container').addClass('container-fluid').removeClass('container');
        } else {
            $('#main-container').removeClass('container-fluid').addClass('container');
        }
    });
    $('#headerfixed').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('header-fixed-top');
            $('.header-container').addClass('shadow-sm');

            if ($('body').hasClass('wrapper-square') == true) {
                var headerheight = $('.header-container').outerHeight();
                $('.wrapper').css('padding-top', headerheight);
            } else {
                var headerheight = $('.header-container').outerHeight() + 15;
                $('.wrapper').css('padding-top', headerheight);
            }
        } else {
            $('body').removeClass('header-fixed-top');
            $('.header-container').removeClass('shadow-sm');
            if ($('body').hasClass('wrapper-square') == true) {
                $('.wrapper').css('padding-top', '0');
            } else {
                $('.wrapper').css('padding-top', '15px');
            }
        }
    });
    $('#headercontainer').on('click', function () {
        if ($(this).is(':checked')) {
            $('#header-container').addClass('container').removeClass('container-fluid');
            $('#submenu-container').addClass('container').removeClass('container-fluid');
        } else {
            $('#header-container').removeClass('container').addClass('container-fluid');
            $('#submenu-container').removeClass('container').addClass('container-fluid');
        }
    });

    $('#headerfillcolor').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('header-fill');
        } else {
            $('body').removeClass('header-fill');
        }
    });
    $('#sidebarCompact').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-compact');
            $('body').removeClass('sidebar-icon');
            $('.sidebar').find('.dropdown').removeClass('show').find('.dropdown-toggle').next().hide();
        } else {
            $('body').removeClass('sidebar-compact');
        }
    });
    $('#sidebarIconic').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-icon');
            $('body').removeClass('sidebar-compact');
            $('.sidebar').find('.dropdown').removeClass('show').find('.dropdown-toggle').next().hide();
        } else {
            $('body').removeClass('sidebar-icon');
        }
    });
    $('#sidebarfull').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').removeClass('sidebar-icon');
            $('body').removeClass('sidebar-compact');
        }
    });

    $('#sidebarFill').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-fill');
        } else {
            $('body').removeClass('sidebar-fill');
        }
    });

    $('#moderntouch').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('modern-touch');
            if ($('body').hasClass('header-fixed-top') == true) {
                var headerheight = $('.header-container').outerHeight() + 15;
                $('.wrapper').css('padding-top', headerheight);
            }


        } else {
            $('body').removeClass('modern-touch');

            if ($('body').hasClass('header-fixed-top') == true) {
                var headerheight = $('.header-container').outerHeight() + 15;
                $('.wrapper').css('padding-top', headerheight);
            } else if ($('body').hasClass('wrapper-square') == true) {
                $('.wrapper').css('padding-top', '0');
            } else {
                $('.wrapper').css('padding-top', '15px');
            }
        }
    });

    $('#fullscreen').on('click', function () {
        if ($(this).is(':checked')) {
            document.documentElement.webkitRequestFullScreen(); // on
        } else {
            document.webkitCancelFullScreen(); //off
        }
    });

    /* fontsize*/
    $('#xsmallfs').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').css('font-size', '13px');
        }
    });
    $('#smallfs').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').css('font-size', '14px');
        }
    });
    $('#mediumfs').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').css('font-size', '15px');
        }
    });
    $('#largefs').on('click', function () {
        if ($(this).is(':checked')) {
            $('body').css('font-size', '16px');
        }
    });


    /* style color  */
    $('.style-picker').on('click', function () {
        $('.style-picker').removeClass('active')
        $(this).addClass('active')
        var currentstyle = $('#stylelink');
        var applystyle = $(this).attr('data-target');
        $('head').append('<link href="../assets/css/' + applystyle + '.css" rel="stylesheet" id="stylelink">');
        setTimeout(function () {
            currentstyle.remove();
        }, 200)

    });

});
