<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary">
                    <a href="{{ route('home') }}" class="text-center mt-2 mb-2 text-dark">
                        <img src="{{ asset('images/smart-unlock.png') }}" alt="logo" width="100" class="mb-2">
                    </a>
                    <p class="text-center">Login Now</p>
                    <div class="card-body">
                        <form method="POST" action="#" class="needs-validation" novalidate="">
                            <div class="form-group">
                                <label for="phone">Mobile Number</label>
                                <input id="phone" type="number" class="form-control" placeholder="Mobile Number" tabindex="1" required>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="Login()" class="btn btn-custom btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
