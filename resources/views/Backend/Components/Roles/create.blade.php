<div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create Role</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p-1">
                                    <label for="roleName" class="form-label">Role Name <label class="text-danger">*</label></label>
                                    <input type="text" class="form-control" placeholder="Role Name" id="roleName">
                                </div>
                                <div class="col-12 p-1">
                                    <label for="permissionName" class="form-label">Permissions</label>
                                    <div id="permissions">
                                    </div>
                                </div>
                                <div class="col-12 p-1">
                                    <label for="roleStatus" class="form-label">Status <label class="text-danger">*</label></label>
                                    <select id="roleStatus" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark w-100" id="create-modal-close" data-dismiss="modal">Close</button>
                    <button type="button" onclick="Save()" class="btn btn-custom w-100">Create</button>
                </div>
            </div>
    </div>
</div>
