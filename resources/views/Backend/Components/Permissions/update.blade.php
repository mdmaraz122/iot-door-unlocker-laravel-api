<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Permission</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label" for="permissionNameUpdate">Permission Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="permissionNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" data-dismiss="modal"  class="btn btn-dark w-100">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-custom w-100" >Update</button>
            </div>
        </div>
    </div>
</div>
