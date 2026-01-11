<section class="section">
    <div class="row ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-1 text-danger"><b>403</b></h1>
                    <h2 class="mb-4 text-danger">Access Denied</h2>
                    <p class="mb-4">You do not have permission to access this page.</p>
                    <a href="{{ url()->previous() == url()->current() ? route('backend.dashboard') : url()->previous() }}"
                       class="btn btn-custom btn-lg">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
