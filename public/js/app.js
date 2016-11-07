page('/sign-in', function(){
    var view = $('#sign-in-view').html();
    var signUp = $('<a  href="/sign-up" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign Up</a>');
    var app = $('#app');
    var menuRight = $('#menu-right');

    signUp.click(on_link_click);

    menuRight.html(signUp);

    app.html(view);
})

page('/sign-up', function(){
    var view = $('#sign-up-view').html();
    var app = $('#app');
    var menuRight = $('#menu-right');
    var signIn = $('<a href="/sign-in" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign In</a>');

    signIn.click(on_link_click);

    menuRight.html(signIn);

    app.html(view);
})

page('*', function(){
    page('/sign-in')
})

page();

$(function(){
    $('a').click(on_link_click);
});


function on_link_click(e) {
    var url = $(this).attr('href');
    page(url);
    e.preventDefault();
}