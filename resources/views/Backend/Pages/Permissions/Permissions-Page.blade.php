@section('title', 'Permissions')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Permissions.list')
    @include('Backend.Components.Permissions.create')
    @include('Backend.Components.Permissions.update')
    @include('Backend.Components.Permissions.delete')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            getList();
        });
        //------------Get List
        async function getList() {
            try {
                showLoader();
                let res = await axios.get("/SecureDataControls/get-permissions");
                hideLoader();

                let tableList = $("#tableList");

                if ($.fn.DataTable.isDataTable('#tableData')) {
                    $('#tableData').DataTable().destroy();
                }

                tableList.html(''); // Clear old rows

                res.data.data.forEach(function(item, index) {
                    tableList.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>
                        @can('permission-update')
                        <button data-id="${item.id}" class="btn editBtn btn-sm btn-success">Edit</button>
                        @endcan
                        @can('permission-delete')
                        <button data-id="${item.id}" class="btn deleteBtn btn-sm btn-danger">Delete</button>
                        @endcan
                    </td>
                </tr>
            `);
                });

                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpUpdateForm(id)
                    $("#update-modal").modal('show');
                });

                $('.deleteBtn').on('click', function () {
                    let id = $(this).data('id');
                    $("#delete-modal").modal('show');
                    $("#deleteID").val(id);
                });

                new DataTable('#tableData', {
                    order: [[0, 'desc']],
                    lengthMenu: [5,10,15,20,30]
                });

            } catch (e) {
                hideLoader();

                console.log("AXIOS ERROR:", e);

                if (e.response) {
                    console.log("Response:", e.response);
                    unauthorized(e.response.status);
                } else {
                    console.log("Request:", e.request);
                    console.log("Message:", e.message);
                    alert("Server not responding or network error!");
                }
            }
        }
        //------------Save Permission
        async function Save() {
            try {
                // Get Form Values
                let name = document.getElementById('permissionName').value;
                // Validation
                if(name===""){
                    errorToast("Permission Name is required");
                    return;
                }
                // Axios Post Request
                showLoader();
                let res = await axios.post("/SecureDataControls/create-permissions",{name:name});
                hideLoader();
                // Response Handling
                if(res.data['status']==="success"){
                    successToast(res.data['message']);
                    document.getElementById('permission-create-close').click();
                    document.getElementById("save-form").reset();
                    await getList();
                }
                else{
                    errorToast(res.data['message'])
                }

            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        //------------Update Permission
        // Fill Up Update Form
        async function FillUpUpdateForm(id){
            try {
                document.getElementById('updateID').value = id;
                showLoader();
                let res=await axios.post("/SecureDataControls/permission-by-id",{ id:id });
                hideLoader();
                document.getElementById('permissionNameUpdate').value=res.data['data']['name'];
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // Update Function
        async function Update() {
            try {
                // Get Form Values
                let name = document.getElementById('permissionNameUpdate').value;
                let updateID = document.getElementById('updateID').value;
                // Validation
                if(name===""){
                    errorToast("Permission name is required")
                }else{
                    // Axios Post Request
                    showLoader();
                    let res = await axios.post("/SecureDataControls/permission-update-by-id/",{name:name,id:updateID});
                    hideLoader();
                    // Response Handling
                    if(res.data['status']==="success"){
                        document.getElementById('update-modal-close').click();
                        document.getElementById("update-form").reset();
                        successToast(res.data['message'])
                        await getList();
                    }
                    else{
                        errorToast(res.data['message'])
                    }
                }
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        //------------Delete Permission
        async  function  itemDelete(){
            try {
                // Get ID
                let id=document.getElementById('deleteID').value;
                document.getElementById('delete-modal-close').click();
                // Axios Post Request
                showLoader();
                let res=await axios.post("/SecureDataControls/permission-delete-by-id",{id:id});
                hideLoader();
                // Response Handling
                if(res.data['status']==="success"){
                    successToast(res.data['message'])
                    await getList();
                }
                else{
                    errorToast(res.data['message'])
                }
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
    </script>
@endsection
