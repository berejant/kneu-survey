$.fn.cssAnimate = function (effect) {
    var className = effect + ' animated';

    return $(this).addClass(className).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass(className);
    });
};

$(function() {
    var $container = $('.container.animate');
    $container.show().cssAnimate('fadeInRight');

    $(window).on('beforeunload', function() {
        $container.cssAnimate('fadeOutLeft');
    });
});
