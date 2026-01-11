<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <div class="col-md-12 p-1">
                                    <label for="updateName" class="form-label">Full Name <label class="text-danger">*</label></label>
                                    <input type="text" class="form-control" placeholder="Full Name" id="updateName">
                                </div>
                                <div class="col-md-12 p-1">
                                    <label for="updateEmailAddress" class="form-label">Email Address <label class="text-danger">*</label></label>
                                    <input type="email" class="form-control" placeholder="Email Address" id="updateEmailAddress">
                                </div>
                                <div class="col-md-12 p-1">
                                    <label for="updatePhone" class="form-label">Mobile Number <label class="text-danger">*</label></label>
                                    <input type="email" class="form-control" placeholder="Mobile Number" id="updatePhone">
                                </div>
                                <div class="col-md-12 p-1">
                                    <label for="updatePassword" class="form-label">Password <label class="text-danger">*</label></label>
                                    <input type="password" class="form-control" placeholder="Password" id="updatePassword">
                                </div>
                                <div class="col-md-12 p-1">
                                    <label for="updatePasskey" class="form-label">Passkey <label class="text-danger">*</label></label>
                                    <input type="password" class="form-control" placeholder="Passkey" id="updatePasskey">
                                </div>
                                <div class="col-md-12 p-1">
                                    <label for="updateStatus" class="form-label">Status <label class="text-danger">*</label></label>
                                    <select id="updateStatus" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Banned">Banned</option>
                                    </select>
                                </div>
                                <p class="text-center">-----Roles-----</p>
                                <div id="updateRole">

                                </div>
                            </div>
                            <input class="d-none" id="updateID"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-dark w-100" id="user-update-close" data-dismiss="modal">Close</button>
                <button type="button" onclick="Update()" class="btn btn-custom w-100">Update</button>
            </div>
        </div>
    </div>
</div>
