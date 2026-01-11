@section('title', 'Roles')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Roles.list')
    @include('Backend.Components.Roles.create')
    @include('Backend.Components.Roles.update')
    @include('Backend.Components.Roles.delete')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            getList();
            // Load Permissions for Create Role
            getPermissions();
        });
        //------------Get List
        async function getList() {
            try {
                showLoader();
                let res=await axios.get("/SecureDataControls/get-roles");
                hideLoader();

                let tableList=$("#tableList");
                let tableData=$("#tableData");

                tableData.DataTable().destroy();
                tableList.empty();

                res.data['data'].forEach(function (item,index) {
                    let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['name']}</td>
                    <td>
                        <button class="btn btn-sm btn-${item['status'] === 1 ? 'success' : 'danger'}">
                            ${item['status'] === 1 ? 'Active' : 'Inactive'}
                        </button>
                    </td>
                    <td>
                        @can('role-update')
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-success">Edit</button>
                        @endcan
                        @can('role-delete')
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-danger">Delete</button>
                        @endcan
                    </td>
                 </tr>`
                    tableList.append(row)
                })

                $('.editBtn').on('click', async function () {
                    let id= $(this).data('id');
                    await FillUpUpdateForm(id)
                    $("#update-modal").modal('show');
                })

                $('.deleteBtn').on('click',function () {
                    let id= $(this).data('id');
                    $("#delete-modal").modal('show');
                    $("#deleteID").val(id);
                })

                new DataTable('#tableData',{
                    order:[[0,'desc']],
                    lengthMenu:[5,10,15,20,30]
                });

            }catch (e) {
                unauthorized(e.response.status)
            }

        }
        //------------Save Role
        // Get Permissions
        async function getPermissions() {
            try {
                showLoader();
                let res = await axios.get("/SecureDataControls/get-permissions");
                hideLoader();

                let permissions = $("#permissions");
                permissions.empty();

                if (res.data['data'].length === 0) {
                    permissions.append(`<p class="text-muted">No permissions available</p>`);
                    return;
                }

                res.data['data'].forEach(function (item) {
                    let row = `
                <div class="form-check form-switch">
                    <input class="form-check-input permissionId" type="checkbox" value="${item['id']}" role="switch" id="${item['name']}">
                    <label class="form-check-label" for="${item['name']}">${item['name']}</label>
                </div>
            `;
                    permissions.append(row);
                });

            } catch (e) {
                hideLoader();
                unauthorized(e.response?.status);
                $("#permissions").empty().append(`<p class="text-danger">Failed to load permissions</p>`);
            }
        }
        // Save Form
        async function Save() {
            try {
                let roleName = document.getElementById('roleName').value;
                let status = document.getElementById('roleStatus').value;
                let permissionId = [];
                // Correctly select all checked permission checkboxes
                let permissionIdList = document.querySelectorAll('.permissionId:checked');
                // Loop through the selected checkboxes and push their values
                permissionIdList.forEach(function (item) {
                    permissionId.push(item.value);
                });
                if (roleName === "") {
                    errorToast("Role Name is required");
                    return;
                }
                if (status === "") {
                    errorToast("Status is required");
                    return;
                }
                showLoader();
                let res = await axios.post("/SecureDataControls/create-roles", {
                    role_name: roleName,
                    status: status,
                    permission_ids: permissionId,
                });

                hideLoader();

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    document.getElementById('create-modal-close').click();
                    document.getElementById("save-form").reset();
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (e) {
                unauthorized(e.response.status);
            }
        }
        //------------Update Role
        // Fill Up Update Form
        async function FillUpUpdateForm(id){
            try {
                document.getElementById('updateID').value = id;
                showLoader();
                let res=await axios.post("/SecureDataControls/role-by-id",{ id:id });
                let permissionData = await axios.get("/SecureDataControls/get-permissions");
                let roleHasPermissionById = await axios.post("/SecureDataControls/get-role-has-permissions-by-id",{ id:id });

                hideLoader();
                document.getElementById('updateRoleName').value=res.data['data']['name'];
                document.getElementById('updateRoleStatus').value=res.data['data']['status'];

                let permissions = $("#updatePermissions");
                permissions.empty();

                if (permissionData.data['data'].length === 0) {
                     permissions.append(`<p class="text-muted">No permissions available</p>`);
                     return;
                }
                 permissionData.data['data'].forEach(function (item) {
                    let row = `
                <div class="form-check form-switch">
                    <input class="form-check-input updatePermissionId" type="checkbox" value="${item['id']}" role="switch" id="update_${item['name']}">
                    <label class="form-check-label" for="update_${item['name']}">${item['name']}</label>
                </div>
            `;
                    permissions.append(row);
                });
                roleHasPermissionById.data['data'].forEach(function (item) {
                    document.getElementById('update_'+item['name']).checked = true;
                });
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // Update Function
        async function Update() {
            try {
                let roleName = document.getElementById('updateRoleName').value;
                let id = document.getElementById('updateID').value;
                let status = document.getElementById('updateRoleStatus').value;
                let permissionId = [];
                // Correctly select all checked permission checkboxes
                let permissionIdList = document.querySelectorAll('.updatePermissionId:checked');
                // Loop through the selected checkboxes and push their values
                permissionIdList.forEach(function (item) {
                    permissionId.push(item.value);
                });
                if (roleName === "") {
                    errorToast("Role Name is required");
                    return;
                }
                showLoader();
                let res = await axios.post("/SecureDataControls/update-roles", {
                    id: id,
                    role_name: roleName,
                    status: status,
                    permission_ids: permissionId
                });
                hideLoader();
                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    document.getElementById('update-modal').click();
                    document.getElementById("save-form").reset();
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (e) {
                unauthorized(e.response.status);
            }
        }
        //------------Delete Role
        async  function  itemDelete(){
            try {
                let id=document.getElementById('deleteID').value;
                document.getElementById('delete-modal-close').click();
                showLoader();
                let res=await axios.post("/SecureDataControls/role-delete-by-id",{id:id});
                hideLoader();
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
