$(document).ready(function () {
    $('#area-biografia').keyup(function (e) {
        var $textarea = $(this),
            maxlength = parseInt($textarea.attr('maxlength')),
            valuelength = $textarea.val().length;
        e.preventDefault();
        $('#max-biografia').text(maxlength - valuelength);
    });

    $('#area-presentacion').keyup( function(e){
        var txt = $(this);
        var wordCount = txt.val().split(' ').length;
        var max = 100;
        e.preventDefault();
        $( '#max-presentacion' ).text(max-wordCount);
    });

    $('.mas-info__body').slideUp();
    var $textmas = '+ Más información';
    var $textmenos = '- Menos información';

    $('.button--masinfo').on('click', function(e){
        $(this).siblings('.mas-info__body').slideToggle(200);
        $(this).parents('.common-box--card').toggleClass('active');
        $(this).text(function (i, text) {
            return text === $textmenos ? $textmas : $textmenos;
        });
        e.preventDefault();
    });

    $('.menu--special a').click(function(e){
        e.preventDefault();
        window.location.href = '/sponsors/';
    });

    $('.menu-item a').on('click', function(e){
        e.preventDefault();
        $('.nav-bar__body').toggleClass('deployed', 2000);
        $('.nav-bar__deploy-button').toggleClass('deployed', 2000);
    });

    // Cache selectors
    var lastId,
        topMenu = $("#nav-bar__menu"),
        topMenuHeight = topMenu.outerHeight()+50,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
    scrollItems = menuItems.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
    });

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function(e){
        var href = $(this).attr("href"),
            offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight;
        $('html, body').stop().animate({
            scrollTop: offsetTop
        }, 500);
        e.preventDefault();
    });

    // Bind to scroll
    $(window).scroll(function(e){
        e.preventDefault();
        // Get container scroll position
        var fromTop = $(this).scrollTop()+topMenuHeight;

        // Get id of current scroll item
        var cur = scrollItems.map(function(){
            if ($(this).offset().top < fromTop)
            return this;
        });
        // Get the id of the current element
        cur = cur[cur.length-1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .parent().removeClass("menu-item--current")
                .end().filter("[href='#"+id+"']").parent().addClass("menu-item--current");
        }
    });
});
