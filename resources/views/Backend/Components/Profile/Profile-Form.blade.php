<div class="col-md-12">
    <div class="card">
        <div class="padding-20">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                       aria-selected="true">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                       aria-selected="false">Password</a>
                </li>
            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="name">Name</label>
                            <input id="name" placeholder="Name" class="form-control" type="text"/>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="email">Email Address</label>
                            <input id="email" placeholder="Email Address" class="form-control" type="email"/>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="phone">Mobile Number</label>
                            <input id="phone" placeholder="Mobile Number" class="form-control" type="number"/>
                        </div>
                        <div class="col-md-12 p-2 mt-4">
                            <button onclick="onUpdate()" class="btn w-100 btn-custom">Update</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="current_password">Current Password</label>
                                            <input id="current_password" placeholder="Current Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="new_password">New Password</label>
                                            <input id="new_password" placeholder="New Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input id="confirm_password" placeholder="Confirm Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12 p-2 mt-4">
                                            <button onclick="onUpdatePassword()" class="btn w-100 btn-custom">Update Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Change Passkey</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="current_passkey">Current Passkey</label>
                                            <input id="current_passkey" placeholder="Current Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="new_passkey">New Passkey</label>
                                            <input id="new_passkey" placeholder="New Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="confirm_passkey">Confirm Passkey</label>
                                            <input id="confirm_passkey" placeholder="Confirm Password" class="form-control" type="password"/>
                                        </div>
                                        <div class="col-md-12 p-2 mt-4">
                                            <button onclick="onUpdatePasskey()" class="btn w-100 btn-custom">Update Passkey</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
