<?php $this->layout('layout', ['title' => 'PikyPak']); ?>

<?php $this->start('page');?>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="color: #d9230f" href="/">PikyPak</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">

            </div>
        </div>
    </nav>
    <div class="container" id="app">

    </div>

    <script id="create-category-modal-view" type="text/template">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create "Category"</h4>
                </div>
                <div class="modal-body">
                    <div class="well bs-component">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="title" class="col-lg-3 control-label">Name<span class="obligate">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="title" class="form-control" id="title">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancel-model-action" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="submit-model-action" type="button" class="btn btn-primary">Create</button>
                </div>
                </div>
            </div>
        </div>
    </script>

    <script id="edit-location-modal-view" type="text/template">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit "Location"</h4>
                </div>
                <div class="modal-body">
                    <div class="well bs-component">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-lg-3 control-label">Name<span class="obligate">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-lg-3 control-label">Description</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="description" rows="3" id="description"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancel-model-action" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="submit-model-action" type="button" class="btn btn-primary">Save</button>
                </div>
                </div>
            </div>
        </div>
    </script>

    <script id="create-location-modal-view" type="text/template">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create "Location"</h4>
                </div>
                <div class="modal-body">
                    <div class="well bs-component">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-lg-3 control-label">Name<span class="obligate">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-lg-3 control-label">Description</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="description" rows="3" id="description"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancel-model-action" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="submit-model-action" type="button" class="btn btn-primary">Create</button>
                </div>
                </div>
            </div>
        </div>
    </script>

    <script id="category-item-view" type="text/template">
         <li class="list-group-item">
            <a href="#" id="delete-action" class="fa fa-times pull-right cat-action" style="font-size: 16px;"></a>
            <a href="#" id="edit-action" class="fa fa-pencil pull-right cat-action" style="font-size: 16px; margin-right: 3px;"></a>
            <a href="#" id="open-category-action">{{ title }}</a>
        </li>
    </script>

    <script id="location-item-view" type="text/template">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left"><span class="fa fa-map-marker"></span> {{ name }}</div>
                <div class="pull-right">
                        <a href="#" id="delete-action" class="fa fa-times pull-right cat-action" style="font-size: 16px;"></a>
                    <a href="#" id="edit-action" class="fa fa-pencil pull-right cat-action" style="font-size: 16px; margin-right: 3px;"></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ description }}
            </div>
        </div>
    </script>
    
    <script id="preferences-view" type="text/template">
        <div class="row">
            <h1>Preferences</h1>
            <hr>
            <div class="col-xs-8 col-xs-offset-2">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">Categories</a>
                    </li>
                    <li role="presentation">
                        <a href="#locations" aria-controls="locations" role="tab" data-toggle="tab">Locations</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="categories">
                    <br>
                        <div class="row">
                            <div class="col-xs-10">
                                <ul class="breadcrumb" id="tree-holder">
                                    <li>Home</li>
                                </ul>
                            </div>
                            <div class="col-xs-2">
                                <a href="#" id="create-category-action" class="btn btn-default pull-right"><span class="fa fa-plus"></span> Create</a>
                            </div>
                        </div>
                        <div id="categories-holder"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane"  id="locations">
                        <br>
                        
                        <div class="row">
                            <div class="col-xs-10">
                                <p style="padding-top: 8px;">Location is used to identify a point or an area on the Earth's surface or elsewhere.</p>
                            </div>
                            <div class="col-xs-2">
                                <a href="#" id="create-location-action" class="btn btn-default pull-right"><span class="fa fa-plus"></span> Create</a>
                            </div>
                        </div>
                        <hr>
                        <form id="search-location-form">
                            <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            <input autocomplete="off" class="form-control" id="inputdefault" type="text" placeholder="Search for locations ...">
                        </div>
                        </form>
                        <br>
                        <div id="locations-holder"></div>
                        <ul class="pager">
                            <li id="newer-locations" class="previous disabled"><a href="#">&larr; Newer</a></li>
                            <li id="older-locations" class="next disabled"><a href="#">Older &rarr;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </script>
    
    <script id="create-thing-modal-view" type="text/template">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create "Thing"</h4>
                </div>
                <div class="modal-body">
                    <div class="well bs-component">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-lg-3 control-label">Name<span class="obligate">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-lg-3 control-label">Description</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="3" id="description"></textarea>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Attitude<span class="obligate">*</span></label>
                                <div class="col-lg-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="attitude" id="attitude1" value="positive" checked>
                                            Good
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="attitude" id="attitude2" value="negative">
                                            Bad
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="attitude" id="attitude3" value="neutral">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rate" class="col-lg-3 control-label">Rate</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="rate" name="rate">
                                        <option value="">None</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create</button>
                </div>
                </div>
            </div>
        </div>
    </script>

    <script id="nav-authenticated-view" type="text/template">
        <ul class="nav navbar-nav" id="nav-authenticated">
            <li class="dropdown" id="things-item">
                <a href="/things" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Things <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/things/good">Good</a></li>
                    <li><a href="/things/bad">Bad</a></li>
                    <li><a href="/things/other">Other</a></li>
                    <li class="divider"></li>
                    <li><a href="/things/all">All</a></li>
                </ul>
            </li>
        </ul>
        <div class="nav navbar-nav" style="margin-top: 5px; width: 250px;">
            <input type="text" class="form-control input-sm" placeholder="Search for things ...">
        </div>
         <ul class="nav navbar-nav">
            <li><a href="/help">Help</a></li>
        </ul>
    </script>

    <script id="profile-update-view" type="text/template">
        <div class="row">
            <h1>Profile</h1>
            <hr>
            <div class="col-xs-8 col-xs-offset-2">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#password" aria-controls="password" role="tab" data-toggle="tab">Password</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" style="padding: 10px;" id="profile">
                        <div class="well bs-component">
                            <form class="form-horizontal" id="update-profile-form">
                                <div class="form-group">
                                    <label for="email" class="col-lg-3 control-label">Email<span class="obligate">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="email" name="email" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="firstName" class="col-lg-3 control-label">First name<span class="obligate">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="firstName" class="form-control" id="firstName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="firstName" class="col-lg-3 control-label">Last name<span class="obligate">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="lastName" class="form-control" id="lastName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9 pull-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" style="padding: 10px;" id="password">
                        <div class="well bs-component">
                            <form class="form-horizontal" id="change-password-form">
                                <div class="form-group">
                                    <label for="password1" class="col-lg-3 control-label">Password<span class="obligate">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="password" name="password" class="form-control" id="password1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="col-lg-3 control-label no-left-padding">Re-enter password<span class="obligate">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="password" class="form-control" id="password2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9 pull-right">
                                        <button type="submit" class="btn btn-primary">Change</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="actions-authenticated-view" type="text/template">
    
        <div class="btn-group navbar-btn btn-group-sm navbar-right" id="nav-actions" style="margin-top: 5px;">
            <a id="user-fullname" href="/profile" class="btn btn-default">{{ name }}</a>
            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="/profile">Profile</a></li>
                <li><a href="/preferences">Preferences</a></li>
                <li class="divider"></li>
                <li><a href="#" id="sign-out">Sign Out</a></li>
            </ul>
        </div>
    </script>

    <script id="sign-up-view" type="text/template">
        <div class="row">
            <h1>Sign Up</h1>
            <hr>
            <div class="col-lg-6 well bs-component">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="email" class="col-lg-3 control-label">Email<span class="obligate">*</span></label>
                        <div class="col-lg-9">
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password1" class="col-lg-3 control-label">Password<span class="obligate">*</span></label>
                        <div class="col-lg-9">
                            <input type="password" name="password" class="form-control" id="password1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password2" class="col-lg-3 control-label no-left-padding">Re-enter password<span class="obligate">*</span></label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control" id="password2">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-3 control-label">First name<span class="obligate">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="firstName" class="form-control" id="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-3 control-label">Last name<span class="obligate">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="lastName" class="form-control" id="lastName">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 pull-right">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </script>

    <script id="sign-in-view" type="text/template">
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <h1>Sign In</h1>
                <hr>
                <div class="well bs-component">
                    <form>
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>

                        <button class="btn btn-primary pull-right">Sing In</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </script>

<?php $this->stop('page'); ?>