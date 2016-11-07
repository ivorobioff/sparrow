$(function(){
    $('a').click(on_link_click);

    page('/sign-in', function(){
        Dispatcher.dispatch('signIn')
    });

    page('/sign-up', function(){
        Dispatcher.dispatch('signUp')
    });

    page('/profile', function(){
        Dispatcher.dispatch('profile');
    });

    page('/', function(){
        Dispatcher.dispatch('things');
    });

    page('/things', function(){
        Dispatcher.dispatch('things');
    });

    page('*', function(){
        Dispatcher.dispatch('notFound');
    });

    page();
});



/* ------------------------------------------------- SUPPORT ----------------------------------------------- */

var AuthDelegate = {

    dispatch: function(name, c){
        if (Session.has()){
            page.redirect('/');
            return false;
        }
    },

    signUp: function(){
        var view = $($('#sign-up-view').html());
        var signIn = $('<a href="/sign-in" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign In</a>');

        signIn.click(on_link_click);

        this.menu.html(signIn);

        view.find('form').submit(function(e){

            var f = form($(this));

            f.validate = function(){
                var pass1 = f.el.find('#password1').val();
                var pass2Input = f.el.find('#password2');
                var pass2 = pass2Input.val();

                if (pass1 !== pass2){
                    pass2Input.after('<div class="help-block">This password does not match the password above.</div>');
                    pass2Input.parents('.form-group').addClass('has-error');

                    return false;
                }

                return true;
            };

            f.submit({url: '/users', session: false}, e).done(function(){
                page.redirect('/sign-in');
            });
        });

        this.layout.html(view);
    },

    signIn: function(){
        var view = $($('#sign-in-view').html());
        var signUp = $('<a  href="/sign-up" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign Up</a>');

        signUp.click(on_link_click);

        this.menu.html(signUp);

        view.find('form').submit(function(e){
            var f = form($(this));

            var showErrors = f.showErrors;

            f.showErrors = function(errors){
                if (typeof errors.credentials !== 'undefined'){
                    errors.email = errors.credentials;
                }
                showErrors(errors);
            };

            f.submit({url: '/sessions', session: false}, e).done(function(data){
                localStorage.setItem('session', JSON.stringify(data));
                page.redirect('/');
            });
        });

        this.layout.html(view);
    }
};

var MainDelegate = {

    init: function(){
        var s = Session.get();

        var actions = $(Mustache.render(
            $('#actions-authenticated-view').html(), { name: s.user.firstName + ' ' + s.user.lastName })
        );

        actions.find('#sign-out').click(function(e){
            e.preventDefault();

            backend('DELETE', '/sessions/' + s.id).done(function(){
                Session.destroy();
                page.redirect('/sign-in');
            }).fail(function(){
                alert('Unable to sign out!');
            });
        });

        var nav = $($('#nav-authenticated-view').html());

        this.menu.html('');
        this.menu.append(nav);
        this.menu.append(actions);
    },

    dispatch: function(name, c){
        if (!Session.has()){
            page.redirect('/sign-in');

            return false;
        }
    },

    things: function(){
        this.layout.html('<h1>Things</h1>');
    },

    profile: function(c){
        this.layout.html('<h1>Profile</h1>');
    },

    notFound: function(){
        this.layout.html('<h1>Not Found!</h1>');
    }
};

var Dispatcher = {

    delegates: [MainDelegate, AuthDelegate],

    _initialized: false,

    dispatch: function(name, c) {

        var _this = this;

        if (_this._initialized === false){
            _this.menu = $('#menu');
            _this.layout = $('#app');
            _this._initialized = true;
        }

        var resolve = function(name){
            for (var i in _this.delegates){

                var delegate = _this.delegates[i];

                if (typeof delegate[name] === 'function'){
                    return delegate;
                }
            }
        };

        var delegate = resolve(name);

        delegate.menu = this.menu;
        delegate.layout = this.layout;

        if (typeof delegate['dispatch'] === 'function'){
            if (delegate.dispatch() === false){
                return ;
            }
        }

        if (_this._currnet !== delegate){
            _this._currnet = delegate;

            if (typeof delegate['init'] === 'function'){
                delegate.init();
            }
        }

        _this.layout.html('');

        delegate[name].apply(delegate, c);
    }
};

var Session = {
    get: function(){
        var session = localStorage.getItem('session');

        if (session === null){
            return null;
        }

        return $.parseJSON(session);
    },

    has: function(){
        return localStorage.getItem('session') !== null;
    },

    destroy: function(){
        localStorage.removeItem('session');
    }
};

function form(el)  {
    var o = {
        el: el,
        validate: function(){ return true;},
        
        submit: function (options, e) {
            e.preventDefault();

            if (typeof options === 'string'){
                options = { url: options };
            }

            el.find('.has-error').removeClass('has-error');
            el.find('.help-block').remove();

            if (this.validate() === false){
                return ;
            }
        
            var data = {};

            el.find('[name]').each(function(i, el){
                el = $(el);
                var value = el.val();

                if (value){
                    data[el.attr('name')] = value
                }
            });

            el.find('select, input, button').attr('disabled', 'disabled');

            return backend({
                 method: 'POST', 
                 url: options.url, 
                 session: options.session, 
                 data: data
                }).always(function(){
                    el.find('select, input, button').removeAttr('disabled');
                }).fail(function(x){
                    var data = $.parseJSON(x.responseText);
                    if (x.status == 422){
                        o.showErrors(data.errors);
                    } else {
                        el.prepend('<div class="alert alert-danger">' + data.message + '</div>')
                    }

                });
        },

        showErrors: function(errors){
            $.each(errors, function(name, meta){
                var input = el.find('[name="' + name + '"]');
                input.after('<div class="help-block">' + meta.message + '</div>');
                input.parents('.form-group').addClass('has-error');
            });
        }
    };

    return o;
}

function on_link_click(e) {
    var url = $(this).attr('href');

    if (url === '#'){
        return ;
    }

    e.preventDefault();
    return page(url);
}

function backend(method, endpoint, data){

    var options = { session: true };

    if (typeof method === 'string'){
        options.url = endpoint;
        options.data = data;
        options.method = method;
    } else {
        options = $.extend(options, method);
    }

    var config = {
        url: '/api' + options.url,
        type: options.method,
        contentType: 'application/json'
    };

    if (typeof options.data !== 'undefined'){
        config.data = JSON.stringify(options.data);
    }

    if (options.session == true){
        var s = Session.get();
        
        if (s !== null){

            var expiresAt = new Date(s.expiresAt);
            var now = new Date();

            // gives 10 minutes to refresh the session
            
            if (now.getTime() >= (expiresAt.getTime() - 600000)){
                backend('POST', '/sessions/' + s.id + '/refresh').done(function(data){
                    localStorage.setItem('session', JSON.stringify(data));
                    s = data;
                }).fail(function(){
                    localStorage.removeItem('session');
                    page.redirect('/');
                });
            }
            
            config.headers = { token: s.token }
        } else {
            page.redirect('/');
        }
    }

    return $.ajax(config);
}
