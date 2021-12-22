// Tab-Pane change function
var tabChange = function () {

    var tabs = $('#car-types > li > a, #car-makes > li > a'),
        active = tabs.filter('.active'),
        next = active.closest('li').next('li').length
            ? active.closest('li').next('li').find('a')
            : tabs.first()
    ;

    next.tab('show');
}

// Tab Cycle function
var tabCycle = setInterval(tabChange, 3000);

// Tab click event handler
$(function () {
    $('#car-types a, #car-makes a').on('click', function (e) {
        e.preventDefault();
        clearInterval(tabCycle);
        $(this).tab('show');
    });
});