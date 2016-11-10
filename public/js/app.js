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

    page('/preferences', function(){
        delegator.delegate('preferences');
    });

    page('/help', function(){
        delegator.delegate('help');
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

        var create = $('<a href="#" style="margin-right: 10px;" class="btn btn btn-primary btn-sm navbar-btn navbar-right"><span class="fa fa-plus"></span> Create</a>');
        
        create.click(function(e){
            var modal = $($('#create-thing-modal-view').html());
            modal.modal('show');
            e.preventDefault();
        });
        
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

    preferences: function(){
        var view = $($('#preferences-view').html());
        var _this = this;

        // CATEGORIES

        var current_category = null;
        var categories = [];

        var template = $('#category-item-view').html();
        var holder = view.find('#categories-holder'); 
        var tree = view.find('#tree-holder');

        var render_tree = function(category){
            tree.html('');

            if (category === null){
                tree.append('<li>Home</li>');
                return ;
            }
            
            var home = $('<li><a href="#">Home</a></li>');
            tree.append(home);

            home.find('a').click(function(e){
                e.preventDefault();
                render_categories(categories, null);
            });

            var append_parents = function(item){
                if (item === null){
                    return ;
                }
                var parent = $(Mustache.render('<li><a href="#">{{ title }}</a></li>', { title: item.title }));

                parent.find('a').click(function(e){
                    e.preventDefault();
                    render_categories(item.children, item);
                });
                append_parents(item.parent);
                tree.append(parent);
            }

            append_parents(category.parent);

            tree.append(Mustache.render('<li>{{ title }}</li>', { title: category.title }));
        };

        var render_categories = function(children, parent){
            if (children.length > 0){
                holder.addClass('well');
                holder.html('');
            } else {
                holder.removeClass('well');
                holder.html('<p style="text-align: center">No Result</p>');
            }

            render_tree(parent);

            $.each(children, function(i, child){
                child.parent = parent;

                var category = $(Mustache.render($('#category-item-view').html(), child));

                category.find('#open-category-action').click(function(e){
                    e.preventDefault();
                    render_categories(child.children, child);
                    render_tree(child);
                    current_category = child;
                });

                category.find('#delete-action').click(function(e){
                    e.preventDefault();

                    if (confirm('Do you want to delete the "' + child.title + '" category?')){
                        backend({ method: 'DELETE', url: '/categories/' + child.id }).done(function(){
                            Show.success('The "' + child.title + '" category has been deleted.');
                            refresh_current_category();
                        });
                    }
                });

                holder.append(category);
            });
        };

        backend({ method: 'GET', url: '/categories' }).done(function(data){
            categories = data.data;
            render_categories(categories, null);
        });
        
        var refresh_current_category = function(){
            if (current_category === null){
                backend({ method: 'GET', url: '/categories' }).done(function(data){
                    categories = data.data;
                    render_categories(categories, null);
                });
            } else {
                backend({ method: 'GET', url: '/categories/' + current_category.id }).done(function(data){
                    current_category.children = data.children;     
                    render_categories(current_category.children, current_category);
                });
            }
        }

        view.find('#create-category-action').click(function(e){
            e.preventDefault();
            
            var modal = new Modal($($('#create-category-modal-view').html()));

            modal.form.onDataReady = function(data){
                if (current_category !== null){
                    data.parent = current_category.id;
                }
            }

            modal.form.el.submit(function(e){

                modal.form.submit({ method: 'POST', url: '/categories' }, e).done(function(data){
                    modal.hide();
                    Show.success('The "' + data.title + '" category has been created.');
                    refresh_current_category();
                });
            });

            modal.show();
        });

        // LOCATIONS

         var reload_locations = function(params){

            params = $.extend({ orderBy: 'id:DESC' }, params);

            var template = $('#location-item-view').html();
            var holder = view.find('#locations-holder');

            var query = '';

            if (typeof params.search !== 'undefined'){
                query = params.search.name;
            }

            view.find('#search-location-form input').val(query);
            
            return backend({ method: 'GET', url: '/locations', data: params }).done(function(data){
                if (data.data.length > 0){
                    holder.addClass('well');
                    holder.html('');
                } else {
                    holder.removeClass('well');
                    holder.html('<p style="text-align: center">No Result</p>');
                }

                var older = view.find('#older-locations');
                var newer = view.find('#newer-locations');

                var pagination = data.meta.pagination;
                
                if (pagination.totalPages > 1 && pagination.totalPages !== pagination.current){
                    older.removeClass('disabled');
                    older.click(function(e){
                        e.preventDefault();
                        params.page = pagination.current + 1;
                        reload_locations(params);
                    });
                } else {
                    older.addClass('disabled', 'disabled');
                }

                if (pagination.current > 1){
                    newer.removeClass('disabled');
                    newer.click(function(e){
                        e.preventDefault();
                        params.page = pagination.current - 1;
                        reload_locations(params);
                    });
                } else {
                    newer.addClass('disabled', 'disabled');
                }

                $.each(data.data, function(i, source){
                    var location = $(Mustache.render(template, source));

                    location.find('#delete-action').click(function(e){
                        e.preventDefault();

                        if (confirm('Do you want to delete the "' + source.name + '" location?')){
                            backend({ method: 'DELETE', url: '/locations/' + source.id }).done(function(){
                                reload_locations();
                                Show.success('The "' + source.name + '" location has been deleted.');
                            });
                        }
                    });

                    location.find('#edit-action').click(function(e){
                        e.preventDefault();
                         var modal = new Modal($($('#edit-location-modal-view').html()));

                         modal.onShow = function(e){
                             modal.form.el.find('[name="name"]').val(source.name);
                             modal.form.el.find('[name="description"]').val(source.description);
                         };

                         modal.form.el.submit(function(e){
                             modal.form.submit({ method: 'PATCH', url: '/locations/' + source.id }, e).done(function(){
                                reload_locations();
                                modal.hide();
                                Show.success('The "' + source.name + '" location has been updated.');
                            });
                         });

                         modal.show();
                    });

                    holder.append(location);
                });
                
            });
        }

        reload_locations();

        view.find('#create-location-action').click(function(e){
            e.preventDefault();
            
            var modal = new Modal($($('#create-location-modal-view').html()));
            
            modal.form.el.submit(function(e){
                 modal.form.submit({ method: 'POST', url: '/locations' }, e).done(function(data){
                    reload_locations();
                    modal.hide();
                    Show.success('The "' + data.name + '" location has been created.');
                });
            });

            modal.show();
        });

        view.find('#search-location-form').submit(function(e){
            e.preventDefault();
            var query = $(this).find('input').val();

            if (query == ''){
                reload_locations();
            } else if (query.length >= 3){
                reload_locations({ search: { name: query } });
            } else {
                Show.warning('The search term must be at least 3 characters long.');
            }
        });

        _this.layout.html(view);
    },

    profile: function(){
        var view = $($('#profile-update-view').html());

        var s = Session.get();

        var _this = this;

        view.find('#email').val(s.user.email);
        view.find('#firstName').val(s.user.firstName);
        view.find('#lastName').val(s.user.lastName);

        view.find('#update-profile-form').submit(function(e){
            var form = new Form($(this));
            form.submit({ method: 'PATCH', url: '/users/' + s.user.id }, e).done(function(data){
                Show.success('You profile has been updated.');
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
            }).done(function(){
                Show.success('The password has been changed.');
            });
        });
        
        _this.layout.html(view);
    },

    help: function(){

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

function Modal(el) {

    var obj = {
        el: el,
        buttons: {
            cancel: el.find('#cancel-model-action'),
            submit: el.find('#submit-model-action')
        },
        show: function(){
            el.modal('show');
        },

        hide: function(){
            el.modal('hide');
        },

        onCancel: function() {},
        onSubmit: function(){
            if (typeof obj.form !== 'undefined'){
                obj.form.el.submit();
            }
        },
        onHide: function() {},
        onShow: function() {},
    };

    var form = el.find('form');

    if (form.length > 0){
        obj.form = new Form(form);
        obj.form.onDisable = function(){
            obj.buttons.submit.attr('disabled', 'disabled');
            obj.buttons.cancel.attr('disabled', 'disabled');
        };

        obj.form.onEnable = function(){
            obj.buttons.submit.removeAttr('disabled');
            obj.buttons.cancel.removeAttr('disabled');
        };
    }

    el.on('hidden.bs.modal', function(e){
        el.remove();
        obj.onHide(e);
    });

    el.on('show.bs.modal', function(e){
        obj.onShow(e);
    });
    

    obj.buttons.cancel.click(function(e){
        obj.onCancel(e);
    });

     obj.buttons.submit.click(function(e){
        obj.onSubmit(e);
    });

    return obj;
}

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

            _this.onDataReady(_this.data);

            el.find('select, input, button, textarea').attr('disabled', 'disabled');
            _this.onDisable();

            options.data = _this.data;

            if (typeof options.session === 'undefined'){
                options.session = true;
            }

            return backend(options).always(function(){
                    el.find('select, input, button, textarea').removeAttr('disabled');
                    _this.onEnable();
                }).fail(function(x){
                    var data = $.parseJSON(x.responseText);
                    if (x.status == 422){
                        o.showErrors(data.errors);
                    } else if(x.status < 500) {
                        Show.error(data.message);
                    }
                });
        },

        onDisable: function() {},
        onEnable: function() {},

        onDataReady: function(){},

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
        if (options.method === 'GET' || options.method === 'DELETE'){
            config.url += '?' + decodeURIComponent($.param(options.data));
        } else {
            config.data = JSON.stringify(options.data);
        }
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

    return $.ajax(config).fail(function(x){
        if (x.status >= 500){
             Show.error('You got an internal server error. Please contact our support center.');   
        }
    });
}


var Show = {
    success: function(message){
        Lobibox.notify('success', {
            msg: message,
            sound: false,
            delay: 3000,
            delayIndicator: false
        });
    },

    warning: function(message){
        Lobibox.notify('warning', {
            msg: message,
            sound: false,
            delay: 3000,
            delayIndicator: false
        })
    },

    error: function(message){
        Lobibox.notify('error', {
            msg: message,
            sound: false,
            delay: 4000,
            delayIndicator: false
        })
    }
}