<?php $this->layout('layout', ['title' => 'Sparrow']); ?>

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
                <a class="navbar-brand" href="/">No Name</a>
            </div>
            <div class="collapse navbar-collapse" id="menu-right">

            </div>
        </div>
    </nav>
    <div class="container" id="app">

    </div>

    <script id="sign-up-view" type="text/template">
        <div class="row">
            <h1>Sign Up</h1>
            <hr>
            <div class="col-lg-6 well bs-component">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="email" class="col-lg-3 control-label">Email</label>
                        <div class="col-lg-9">
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password1" class="col-lg-3 control-label">Password</label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control" id="password1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password2" class="col-lg-3 control-label no-left-padding">Re-enter password</label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control" id="password2">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-3 control-label">First name</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-3 control-label">Last name</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="lastName">
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
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" class="form-control" id="email">
                        </div>

                        <button class="btn btn-primary pull-right">Sing In</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </script>

<?php $this->stop('page'); ?>