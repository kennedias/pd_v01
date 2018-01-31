<nav class="navbar  navbar-expand-lg navbar-light bg-light  ">
  <a class="navbar-brand" href="index.html"><img src="images/logo.png" style="width:130px;
   height:80px; border:1px solid;
   border-color:black;" ><span>Puzzle Dating Website</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="background: teal;">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse  " id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item order-1 "> 
            <a class="nav-link nav-link1" href="AboutUs.html">About Us</a>
            </li>
            <li class="nav-item order-2 order-md-1"><a href="#" class="nav-link" title="settings"><i class="fa fa-cog fa-fw fa-lg" style="color:silver;"></i></a></li>
            <li class="dropdown order-3">
                <button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle ">Login <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu-right mt-1">
                  <li class="p-3">
                        <form class="form" role="form" method="post" action="index.php">
                            <div class="form-group">
                                <input  name="email" id="email" placeholder="Email" class="form-control form-control-sm" type="text" required="">
                            </div>
                            <div class="form-group">
                                <input name="password" id="password" placeholder="Password" class="form-control form-control-sm" type="password" required="">
                            </div>
                            <div class="form-group">
                                <button type="submit" value="login" name="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="form-group text-xs-center">
                                <small><a href="#">Forgot password?</a></small>
                            </div>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
  </div>
</nav>