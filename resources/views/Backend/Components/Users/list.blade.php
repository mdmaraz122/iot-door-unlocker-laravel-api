<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4 class="text-dark" onclick="getList()">Users</h4>
                    </div>
                    <div class="align-items-center col text-right">
                        @can('user-create')
                        <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#create-modal">Create</button>
                        @endcan
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <div class="table-responsive">
                <table class="table text-center" id="tableData">
                    <thead>
                    <tr class="bg-gradient-info text-white">
                        <th class="text-center">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email <br/>&<br/> Phone</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
