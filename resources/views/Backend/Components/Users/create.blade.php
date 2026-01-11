<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create User</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <label for="name" class="form-label">Full Name <label class="text-danger">*</label></label>
                                <input type="text" class="form-control" placeholder="Full Name" id="name">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="email" class="form-label">Email Address <label class="text-danger">*</label></label>
                                <input type="email" class="form-control" placeholder="Email Address" id="email">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="phone" class="form-label">Phone Number <label class="text-danger">*</label></label>
                                <input type="number" class="form-control" placeholder="Phone Number" id="phone">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="password" class="form-label">Password <label class="text-danger">*</label></label>
                                <input type="password" class="form-control" placeholder="Password" id="password">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="passkey" class="form-label">Passkey <label class="text-danger">*</label></label>
                                <input type="password" class="form-control" placeholder="Passkey" id="passkey">
                            </div>
                            <div class="col-md-12 p-1">
                                <label for="status" class="form-label">Status <label class="text-danger">*</label></label>
                                <select id="status" class="form-control">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Banned">Banned</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <p class="text-center">-----Roles-----</p>
                                <label for="permissionName" class="form-label">Roles</label>
                                <div id="Roles">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-dark w-100" id="user-create-close" data-dismiss="modal">Close</button>
                <button type="button" onclick="Save()" class="btn btn-custom w-100">Create</button>
            </div>
        </div>
    </div>
</div>
