page('/sign-in', function(){
    var view = $($('#sign-in-view').html());
    var signUp = $('<a  href="/sign-up" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign Up</a>');
    var app = $('#app');
    var menuRight = $('#menu-right');

    signUp.click(on_link_click);

    menuRight.html(signUp);

    app.html(view);
})

page('/sign-up', function(){
    var view = $($('#sign-up-view').html());
    var app = $('#app');
    var menuRight = $('#menu-right');
    var signIn = $('<a href="/sign-in" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign In</a>');

    signIn.click(on_link_click);

    menuRight.html(signIn);

    view.find('form').submit(function(e){
        e.preventDefault();

        var form = $(this);

        var data = {};

        form.find('.has-error').removeClass('has-error');
        form.find('.help-block').remove();

        var pass1 = form.find('#password1').val();
        var pass2Input = form.find('#password2');
        var pass2 = pass2Input.val();

        if (pass1 !== pass2){
            pass2Input.after('<div class="help-block">This password does not match the password above.</div>');
            pass2Input.parents('.form-group').addClass('has-error');

            return ;
        }

        form.find('[name]').each(function(i, el){
            var el = $(el);
            var value = el.val();

            if (value){
                data[el.attr('name')] = value
            }
        });

        form.find('select, input, button').attr('disabled', 'disabled');

        backend('POST', '/users', data).always(function(){
            form.find('select, input, button').removeAttr('disabled');
        }).fail(function(x){
            var data = $.parseJSON(x.responseText);
            if (x.status == 422){
                $.each(data.errors, function(name, meta){
                    var input = form.find('[name="' + name + '"]');
                    input.after('<div class="help-block">' + meta.message + '</div>');
                    input.parents('.form-group').addClass('has-error');
                });
            } else {
                form.prepend('<div class="alert alert-danger">' + data.message + '</div>')
            }

        }).done(function(){
            page('/sign-in');
        });
    });

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

function backend(method, endpoint, data){

    var config = {
        url: '/api' + endpoint,
        type: method,
        contentType: 'application/json'
    };

    if (typeof data !== 'undefined'){
        config.data = JSON.stringify(data);
    }

    return $.ajax(config);
}
