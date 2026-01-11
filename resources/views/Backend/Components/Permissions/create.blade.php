<div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label for="permissionName" class="form-label">Permission Name <label class="text-danger">*</label></label>
                                <input type="text" class="form-control" placeholder="Permission Name" id="permissionName">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-dark w-100" id="permission-create-close" data-dismiss="modal">Close</button>
                <button type="button" onclick="Save()" class="btn btn-custom w-100">Create</button>
            </div>
        </div>
    </div>
</div>
