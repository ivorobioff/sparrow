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
                <a class="navbar-brand" href="/">BBB Inc.</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav"></ul>
                <button type="submit" class="btn btn btn-default btn-sm navbar-btn navbar-right">Sign In</button>
            </div>
        </div>
    </nav>
    <br><br><br>
    <div class="container">
        <div class="row">
            <h1>Sign Up</h1>
            <hr>
            <div class="col-lg-6 well bs-component">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="email" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="col-lg-2 control-label"></label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="confirmPassword">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="lastName">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $this->stop('page'); ?>