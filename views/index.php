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
                <a class="navbar-brand" href="/">PikyPak</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">

            </div>
        </div>
    </nav>
    <div class="container" id="app">

    </div>


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
            <li id="categories-item">
                <a href="/categories">Categories</a>
            </li>
            <li id="locations-item">
                <a href="/locations">Locations</a>
            </li>
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
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Password</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">

                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="actions-authenticated-view" type="text/template">
        <div class="btn-group navbar-btn btn-group-sm navbar-right" style="margin-top: 5px;">
            <a href="/profile" class="btn btn-default">{{ name }}</a>
            <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="/profile">Profile</a></li>
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