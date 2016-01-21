$.fn.cssAnimate = function (effect, hide) {
    var $this = $(this);
    var className = effect + ' animated';

    return $this.addClass(className).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $this.removeClass(className);
        if(hide) {
            $this.hide();
        }
    });
};

$(function() {
    var $container = $('.container.animate');
    $container.show().cssAnimate('fadeInRight');

    $(window).on('beforeunload', function() {
        $container.cssAnimate('fadeOutLeft', true);
    });

    $('#restart').tooltip();
});
