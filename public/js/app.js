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

        var template = $('#category-item-view').html();
        var holder = view.find('#categories-holder'); 
        var tree = view.find('#tree-holder');

        var walker = new CategoryWalker();

        walker.renderHeader = function(category){
            tree.html('');

            if (category === null){
                tree.append('<li>Home</li>');
                return ;
            }
            
            var home = $('<li><a href="#">Home</a></li>');
            tree.append(home);

            home.find('a').click(function(e){
                e.preventDefault();
                walker.open(null);
            });

            var append_parents = function(item){
                if (item === null){
                    return ;
                }
                var parent = $(Mustache.render('<li><a href="#">{{ title }}</a></li>', { title: item.title }));

                parent.find('a').click(function(e){
                    e.preventDefault();
                    walker.open(item.id);
                });
                append_parents(item.parent);
                tree.append(parent);
            }

            append_parents(category.parent);

            tree.append(Mustache.render('<li>{{ title }}</li>', { title: category.title }));
        };

        walker.renderBody = function(children, parent){
            
            if (children.length > 0){
                holder.addClass('well');
                holder.html('');
            } else {
                holder.removeClass('well');
                holder.html('<p style="text-align: center">No Result</p>');
            }
            
            $.each(children, function(i, child){
                var category = $(Mustache.render($('#category-item-view').html(), child));

                category.find('#open-category-action').click(function(e){
                    e.preventDefault();
                    walker.open(child.id);
                });

                category.find('#delete-action').click(function(e){
                    e.preventDefault();

                    if (confirm('Do you want to delete the "' + child.title + '" category?')){
                        backend({ method: 'DELETE', url: '/categories/' + child.id }).done(function(){
                            Show.success('The "' + child.title + '" category has been deleted.');
                            walker.refresh();
                        });
                    }
                });

                category.find('#edit-action').click(function(e){
                    e.preventDefault();
                    
                    var selected_parent = child.parent;

                    var modal = new Modal($($('#edit-category-modal-view').html()));

                    modal.onShow = function(){
                        modal.form.el.find('[name="title"]').val(child.title);
                        modal.form.el.find('#parent-title').text(child.parent === null ? 'Home' : child.parent.title);

                        modal.form.el.find('#edit-action').click(function(e){
                            e.preventDefault();
                            modal.form.el.find('#categories-picker').toggle();
                        });

                        var container = modal.form.el.find('#categories-picker #picker-container');
                        var picker = new CategoryPicker(container);

                        picker.onSelect = function(item){
                            modal.form.el.find('#parent-title').text(item.title);
                            selected_parent = item;
                        };

                        picker.onDeselect = function(){
                            modal.form.el.find('#parent-title').text(child.parent === null ? 'Home' : child.parent.title);
                            selected_parent = child.parent;
                        }
                        
                        if (child.parent !== null){
                             picker.selected = child.parent;
                        } else {
                            picker.selected = { id: null, title: 'Home'};
                        }

                        picker.exclude = child;

                        picker.load(walker.current === null ? null : walker.current.parent);
                    };

                    modal.form.onDataReady = function(data){
                        if (selected_parent === null){
                            data.parent = null;
                        } else {
                            data.parent = selected_parent.id;
                        }
                    };

                    modal.form.el.submit(function(e){
                        modal.form.submit({ method: 'PATCH', url: '/categories/' + child.id }, e).done(function(){
                            modal.hide();
                            Show.success('The "' + child.title + '" category has been updated.');

                            if (selected_parent !== null){
                                walker.open(selected_parent.id);
                            } else {
                                walker.open(null);
                            }
                        });
                    });

                    modal.show();
                });

                holder.append(category);
            });
        };

        walker.open(null);
      
        view.find('#create-category-action').click(function(e){
            e.preventDefault();
            
            var modal = new Modal($($('#create-category-modal-view').html()));

            modal.form.onDataReady = function(data){
                if (walker.current !== null){
                    data.parent = walker.current.id;
                }
            }

            modal.form.el.submit(function(e){

                modal.form.submit({ method: 'POST', url: '/categories' }, e).done(function(data){
                    modal.hide();
                    Show.success('The "' + data.title + '" category has been created.');
                    walker.refresh();
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
                                reload_locations(params);
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


function CategoryWalker(){
    return {
        renderBody: function(children, parent) {},
        renderHeader: function(category) {},
        
        current: null,

        open: function(id){
            var _this = this;
            if (id === null){
                backend({ method: 'GET', url: '/categories' }).done(function(data){
                    _this.current = null;
                    _this.renderBody(data.data, null);
                    _this.renderHeader(null);
                });
            } else {
                backend({ method: 'GET', url: '/categories/' + id }).done(function(data){
                    _this.current = data;
                    $.each(data.children, function(i, child){
                        child.parent = data;
                    });
                    _this.renderBody(data.children, data);
                    _this.renderHeader(data);
                });
            }
        },

        refresh: function(){
            if (this.current === null){
                this.open(null);
            } else {
                this.open(this.current.id);
            }
        }
    }
}

function CategoryPicker(el) {
    return {
        el: el,
        
        exclude: null,
        
        selected: null,

        onSelect: function(item){},
        onDeselect: function(item){},

        load: function(current){
            var _this = this;

            var forward = '<div class="list-group-item"> \
                            <div class="pull-left">{{ title }}</div> \
                            <a href="#" id="next-action" class="pull-right cat-action"><span class="fa fa-chevron-circle-right "></span></a> \
                            <a href="#" id="select-action" class="pull-right cat-action" style="margin-right: 5px;"><span class="fa fa-check"></span></a> \
                            <div class="clearfix"></div> \
                        </div>';

            var backward = '<div class="list-group-item">\
                                <div class="pull-right"><span id="next-step-holder">{{ next }} &nbsp;&nbsp;&nbsp; &larr;</span> &nbsp;&nbsp;&nbsp; {{ current }}</div>\
                                <a href="#" id="select-action" class="pull-left cat-action" style="display: none;"><span class="fa fa-check"></span></a> \
                                <a href="#" id="back-action" class="pull-left cat-action" style="display: none;"><span class="fa fa-chevron-circle-left"></span></a>\
                                <div class="clearfix"></div>\
                            </div>';

            var walker = new CategoryWalker();

            walker.renderBody = function (data, parent){
                el.html('');

                function toggle(source, el){
                    if (_this.selected === null || _this.selected.id != source.id){
                        _this.el.find('.list-group-item .selected').removeClass('selected');
                        el.addClass('selected');
                        _this.onDeselect(_this.selected);
                        _this.selected = source;
                        _this.onSelect(source);
                    } else {
                        _this.onDeselect(_this.selected);
                        _this.selected = null;
                        el.removeClass('selected');
                    }
                }
                
                var title = 'Home';
                var current = 'Home';

                if (parent !== null && parent.parent !== null){
                    title = parent.parent.title;
                }

                if (parent !== null){
                    current = parent.title;
                }

                var back = $(Mustache.render(backward, {next: title, current: current}));

                if (parent === null){
                    back.find('#next-step-holder').remove();
                }

                if (_this.selected && _this.selected.id === null) {
                    back.find('#select-action').addClass('selected');
                }

                if (parent === null){
                    back.find('#select-action').show().click(function(e){
                        e.preventDefault();
                        toggle({ id: null, title: 'Home'}, $(this));
                    });  
                } else {
                    back.find('#back-action').show().click(function(e){
                        e.preventDefault();

                        if (parent.parent === null){
                            walker.open(null);
                        } else {
                            walker.open(parent.parent.id);
                        }
                    });
                }

                el.append(back);

                $.each(data, function(i, source){
                    if (_this.exclude !== null && source.id == _this.exclude.id){
                        return ;
                    }

                    source.parent = parent;

                    var item = $(Mustache.render(forward, { title: source.title }));    

                    if (_this.selected !== null && _this.selected.id == source.id){
                        item.find('#select-action').addClass('selected');
                    }          

                    item.find('#select-action, #next-action').click(function(e){
                        e.preventDefault();
                    });     

                    item.find('#select-action').click(function(e){
                        toggle(source, $(this));
                    });

                    if (source.children.length > 0){
                        item.find('#next-action').click(function(e){
                            walker.open(source.id);
                        });
                    } else {
                        item.find('#next-action').addClass('possive')
                    }

                    el.append(item);
                });
            };
            
            if (current === null){
                walker.open(null);
            } else {
                walker.open(current.id);
            }
        }
    };
}

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