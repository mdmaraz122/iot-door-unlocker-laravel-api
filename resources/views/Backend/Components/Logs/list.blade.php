<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4 class="text-dark">Filter</h4>
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <form>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="users">Select User <span class="text-danger">*</span></label>
                            <select class="form-control" id="users">
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="user"></label>
                            <button class="btn btn-custom btn-sm h-100 w-100" type="button" onclick="getList()"><i class="fa-solid fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4 class="text-dark">Unlock Logs</h4>
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <div class="table-responsive">
                <table class="table text-center" id="tableData">
                    <thead>
                    <tr class="bg-gradient-info text-white">
                        <th class="text-center">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Date & Time</th>
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
