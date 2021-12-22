// Tab click event handler
$(function () {
    /*function hubspotModal(){
        $('#hubspotModal').modal('toggle');
    }
    setTimeout(hubspotModal, 45000);*/

    /*let carlist = $('.maincarlisting .carlist-xxxxx');
    if (typeof carlist !== undefined) {
        carlist.sort(function (a, b) {
            return (+$(a).data('current-area') > +$(b).data('current-area')) ?
                -1 : (+$(a).data('current-area') < +$(b).data('current-area')) ?
                1 : 0;
        });
        $('.maincarlisting .carlistrow').html(carlist);
    }

    carlist = $('.similarcarlisting .carlist-xxxxx');
    if (typeof carlist !== undefined) {
        carlist.sort(function (a, b) {
            return (+$(a).data('current-area') > +$(b).data('current-area')) ?
                -1 : (+$(a).data('current-area') < +$(b).data('current-area')) ?
                1 : 0;
        });
        $('.similarcarlisting .carlistrow').html(carlist);
    }*/

    // Small 576px
    // Medium 768px
    // Large 992px
    // Extra large 1200px

    let pageWidth = $(window).width();
    let tpBreak = '5n';
        if (pageWidth >= 1500) {
            tpBreak = '10n';
        } else if (pageWidth >= 1200) {
            tpBreak = '8n';
        } else if (pageWidth >= 900) {
            tpBreak = '6n';
        } else if (pageWidth >= 768) {
            tpBreak = '4n';
        }


    //$( ".carlistrow .carlist:nth-child("+tpBreak+")").after($( ".trustpilot-widget" ).clone().appendTo($('<div class="col-12"></div>')));
    $( ".carlistrow .carlist:nth-child("+tpBreak+")").after($('.carlist-break').clone().removeClass('d-none'));

    $('.finance-example').on('click', function (e) {
        let rrp = $(this).data('rrp');
        $('.carimage').attr('src', $(this).data('image')).attr('alt', $(this).data('title'));
        $('.carname').text($(this).data('title').toUpperCase());
        financeExamples.forEach(function (financeExample, index) {
            if (financeExample['cashprice'] == rrp) {
                for (let dataKey in financeExample) {
                    if (financeExample.hasOwnProperty(dataKey)) {
                        $('#financeModal .' + dataKey).text(financeExample[dataKey]);
                    }
                }
                $('#financeModal').modal('toggle');
                return;
            }
        });
    });

    $('.drive-away').on('click', function (e) {
        $('#onehourModal').modal('toggle');
    });

    $('.carlist__button, #nav-pfc').on('click', function (e) {
        $('.tab-pfc').click();
    });

    $('#oc-modal-link').on('click', function (e) {
        $('#financeModal').modal('toggle');
        $('.tab-pfc').click();
    });

    $('#oc-modal-link1').on('click', function (e) {
        $('#onehourModal').modal('toggle');
        $('.tab-pfc').click();
    });

    $('.load-more').on('click', function (e) {
        e.preventDefault();
        $('.' + $(this).data('type') + ' .carlist').addClass('showall');
        $(this).remove();
    });

    $('.opening-times').on('click', function (e) {
        e.preventDefault();
        if ($(window).width() < 768) {
            $('#link--locations').click();
        } else {
            if ($(".desktop-branch-info").length) {
                $('html, body').animate({
                    scrollTop: $('.desktop-branch-info').offset().top - (($('header').outerHeight() + $('.content-tabs').outerHeight()) + 22)
                }, 200);
            } else {
                $('html, body').animate({
                    scrollTop: $('.branch-locations').offset().top - (($('header').outerHeight() + $('.content-tabs').outerHeight()) + 22)
                }, 200);
            }
        }
    });

    $(".car-img").each(function(i,ele){
        $("<img/>").attr("src",$(ele).attr("src")).on('error', function() {
            $(ele).addClass('carlist__brokenimage');
            $(ele).attr( "src", "/images/tcw-logo.svg" );
        })
    });

    $(".car-img").on("error", function(){
        $(this).attr( "src", "/images/tcw-logo.svg" );
    });
});
