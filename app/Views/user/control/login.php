<div class="row">

    

      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">

        <?= view('user/control/_session') ?>

        <div class="card card-signin my-2">
          <div class="card-body">
            <h5 class="card-title text-center">Login</h5>
            <form class="form-signin" action="<?= route_to("user_login_post") ?>" method="Post">
              <div class="form-label-group">
                <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
              </div>

              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>