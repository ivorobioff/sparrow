$(function(){
    $('a').click(on_link_click);

    var delegator = new Delegator([AppDelegate]);

    page('/sign-in', function(){
        delegator.delegate('signIn');
    });

    page('/sign-up', function(){
        delegator.delegate('signUp')
    });

    page('/profile', function(){
        delegator.delegate('profile');
    });

    page('/', function(){
        delegator.delegate('things');
    });

    page('/things/:type(good|bad|other|all)', function(){
        delegator.delegate('things');
    });

    page('/things/create', function(){
        delegator.delegate('createThings');
    });

    page('/preferences', function(){
        delegator.delegate('preferences');
    });

    page('*', function(){
        delegator.delegate('notFound');
    });

    page();
});



/* ------------------------------------------------- SUPPORT ----------------------------------------------- */

var AuthDelegate = {
    
    canProceed: function(name, c){
        if (Session.has()){
            page.redirect('/');
            return false;
        }

        return true;
    },

    signUp: function(){
        var view = $($('#sign-up-view').html());
        var signIn = $('<a href="/sign-in" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign In</a>');

        signIn.click(on_link_click);

        this.menu.html(signIn);

        view.find('form').submit(function(e){

            var f = new Form($(this));

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

            f.submit({method: 'POST', url: '/users', session: false}, e).done(function(){
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
            var f = new Form($(this));

            var showErrors = f.showErrors;

            f.showErrors = function(errors){
                if (typeof errors.credentials !== 'undefined'){
                    errors.email = errors.credentials;
                }
                showErrors(errors);
            };

            f.submit({method: 'POST', url: '/sessions', session: false}, e).done(function(data){
                localStorage.setItem('session', JSON.stringify(data));
                page.redirect('/');
            });
        });

        this.layout.html(view);
    }
};

var MainDelegate = {

    didActivate: function(){
        var nav = $($('#nav-authenticated-view').html());

        var s = Session.get();

        var actions = $(Mustache.render(
            $('#actions-authenticated-view').html(), { name: s.user.firstName + ' ' + s.user.lastName })
        );

        actions.find('#sign-out').click(function(e){
            e.preventDefault();

            backend({ method: 'DELETE', url: '/sessions/' + s.id}).done(function(){
                Session.destroy();
                page.redirect('/sign-in');
            }).fail(function(){
                alert('Unable to sign out!');
            });
        });

        var create = $('<a href="/things/create" style="margin-right: 10px;" class="btn btn btn-primary btn-sm navbar-btn navbar-right"><span class="fa fa-plus"></span> Create</a>');
        
        this.menu.html('');
        this.menu.append(nav);
        this.menu.append(actions);
        this.menu.append(create);
        this.nav = this.menu.find('#nav-authenticated');
    },
    
    willDispatch: function(){
       this.nav.find('li.active').removeClass('active');
    },

    canProceed: function(name, c){
        if (!Session.has()){
            page.redirect('/sign-in');

            return false;
        }

        return true;
    },

    things: function(){

    },

    createThings: function(){

    },

    preferences: function(){
        
    },

    profile: function(){
        var view = $($('#profile-update-view').html());

        var s = Session.get();

        var _this = this;

        view.find('[name], button').attr('disabled', 'disabled');

        backend({ method: 'GET', url: '/users/' + s.user.id}).always(function(){
             view.find('[name], button').removeAttr('disabled');
        }).done(function(data){
            view.find('#email').val(data.email);
            view.find('#firstName').val(data.firstName);
            view.find('#lastName').val(data.lastName);
        });

        view.find('#update-profile-form').submit(function(e){
            var form = new Form($(this));
            form.submit({ method: 'PATCH', url: '/users/' + s.user.id }, e).done(function(data){
                backend({ method: 'GET', url: '/sessions/' + s.id}).done(function(data){
                    localStorage.setItem('session', JSON.stringify(data));
                    s = Session.get();
                    _this.menu.find('#user-fullname').text(s.user.firstName + ' ' + s.user.lastName);
                })
            });

        });

        view.find('#change-password-form').submit(function(e){
            var $this = $(this);
            var form = new Form($this);

            form.validate = function(){
                var pass1 = form.el.find('#password1').val();
                var pass2Input = form.el.find('#password2');
                var pass2 = pass2Input.val();

                if (pass1 !== pass2){
                    pass2Input.after('<div class="help-block">This password does not match the password above.</div>');
                    pass2Input.parents('.form-group').addClass('has-error');

                    return false;
                }

                return true;
            };

            form.submit({ method: 'PATCH', url: '/users/' + s.user.id }, e).always(function(){
                $this.find('#password1, #password2').val('');
            });
        });
        
        _this.layout.html(view);
    },

    notFound: function(){
        this.layout.html('<h1>Not Found!</h1>');
    }
};

var AppDelegate = {

    _initialized: false,

    canDispatch: function(){
        return true;
    },

    dispatch: function(name, c) {

        var _this = this;

        if (_this._initialized === false){
            _this.menu = $('#menu');
            _this.layout = $('#app');

            _this.delegator = new Delegator([MainDelegate, AuthDelegate]);

            _this.delegator.didResolve = function(delegate){
                delegate.menu = _this.menu;
                delegate.layout = _this.layout;
            };

            _this.delegator.willDispatch = function(delegate){
                _this.layout.html('');
            };

            _this._initialized = true;
        }

        _this.delegator.delegate(name, c);
    }
};

function Delegator (delegates) {

    return {
        
        delegate: function(name, c){

            var _this = this;

            var resolve = function(name){
                for (var i in delegates){

                    var delegate = delegates[i];

                    if (typeof delegate[name] === 'function'){
                        return delegate;
                    }

                    if (typeof delegate['canDispatch'] === 'function' 
                        && delegate.canDispatch(name)){
                        return delegate;
                    }
                }
            };

            var delegate = resolve(name);

            _this.didResolve(delegate);

            if (typeof delegate['canProceed'] === 'function'){
                if (delegate.canProceed(name, c) === false){
                    return ;
                }
            }

            if (_this._currnet !== delegate){
                _this._currnet = delegate;

                if (typeof delegate['didActivate'] === 'function'){
                    delegate.didActivate();
                }
            }
            
            _this.willDispatch(delegate);

            if (typeof delegate['willDispatch'] === 'function'){
                    delegate.willDispatch(name, c);
            }

            if (typeof delegate[name] === 'function'){
                delegate[name].apply(delegate, c);
            } else {
                delegate.dispatch(name, c);
            }
        },

        willDispatch: function(){},
        didResolve: function(){}
    }
}

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

function Form(el)  {
    var o = {
        el: el,
        data: {},
        validate: function(){ return true;},
        
        submit: function (options, e) {
            e.preventDefault();

            var _this = this;

            el.find('.has-error').removeClass('has-error');
            el.find('.help-block').remove();

            if (_this.validate() === false){
                return ;
            }

            _this.data = {};
        
            el.find('[name]').each(function(i, el){
                el = $(el);
                var value = el.val();

                if (value == ''){
                   value = null;
                }
                 _this.data[el.attr('name')] = value
            });

            el.find('select, input, button').attr('disabled', 'disabled');

            options.data = _this.data;

            if (typeof options.session === 'undefined'){
                options.session = true;
            }

            return backend(options).always(function(){
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

    if (url.startsWith('#')){
        return ;
    }

    e.preventDefault();
    return page(url);
}

function backend(options){

    if (typeof options.session === 'undefined'){
        options.session = true;
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
                backend({ method: 'POST', url: '/sessions/' + s.id + '/refresh'}).done(function(data){
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
