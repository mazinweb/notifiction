/**
 * Created by root on 31/03/17.
 */

// ********************************class asterisk ************************************************
$(function () {

    $('input').each(function () {
        if ($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk"> * </span>');
        }

    });
    //*****************************  convert Password Filed to Text Filed  **************************

    var passFiled = $('.password');
    $('.show-pass').hover(function () {
        passFiled.attr('type', 'text');

    }, function () {
        passFiled.attr('type', 'password');

    });
    //************************ confirm delete *******************************************************

    $('.confirm').click(function () {
        return confirm('are you sure');

    });

    //******************* view option for categories ****************************************************

    $('.cat h3').click(function () {
        $(this).next('.view').fadeToggle();

    });

    $('.option span').click(function () {
        $(this).addClass('active').siblings('span').removeClass('active');

        if( $(this).data('full') == 'full'){
            $('.view').fadeIn();

        }else {
            $('.view').fadeIn();

        }

    });


});
