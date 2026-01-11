@section('title', 'Users')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Users.list')
    @include('Backend.Components.Users.create')
    @include('Backend.Components.Users.update')
    @include('Backend.Components.Users.delete')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            getList();
            getRoles();
        });
        //------------Get List
        async function getList() {
            try {
                showLoader();
                let res = await axios.get("/SecureDataControls/get-users");
                hideLoader();

                let tableList = $("#tableList");
                let tableData = $("#tableData");

                tableData.DataTable().destroy();
                tableList.empty();

                res.data['data'].forEach(function (item, index) {
                    // Check if user ID is 1 (super admin)
                    const isSuperAdmin = item['id'] === 1;

                    let row = `<tr>
                <td>${index + 1}</td>
                <td>${item['name']}</td>
                <td>${item['email']}<br/>${item['phone'] ?? 'none'}</td>
                <td>
                    <button class="btn editBtn btn-sm btn-${item['status'] === 'Active' ? 'success' : 'danger'}">
                        ${item['status']}
                    </button>
                </td>
                <td>
                    @can('user-update')
                    ${!isSuperAdmin ? `<button data-id="${item['id']}" class="btn editBtn btn-sm btn-success">Edit</button>` : ''}
                    @endcan
                    @can('user-delete')
                    ${!isSuperAdmin ? `<button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-danger">Delete</button>` : ''}
                    @endcan
                    </td>
                </tr>`;
                    tableList.append(row);
                });

                $('.editBtn').on('click', function () {
                    let id = $(this).data('id');
                    $("#update-modal").modal('show');
                    FillUpUpdateForm(id);
                    $("#updateID").val(id);
                });

                $('.deleteBtn').on('click', function () {
                    let id = $(this).data('id');
                    $("#delete-modal").modal('show');
                    $("#deleteID").val(id);
                });

                new DataTable('#tableData', {
                    order: [[0, 'desc']],
                    lengthMenu: [5, 10, 15, 20, 30]
                });
            } catch (e) {
                unauthorized(e.response.status);
            }
        }


        //------------Save User
        // Get Roles
        async function getRoles() {
            try {
                showLoader();
                let res = await axios.get("/SecureDataControls/get-roles");
                hideLoader();

                let roles = $("#Roles");
                roles.empty();

                if (res.data['data'].length === 0) {
                    roles.append(`<p class="text-muted">No permissions available</p>`);
                    return;
                }

                res.data['data'].forEach(function (item) {
                    let row = `
                <div class="form-check form-switch">
                    <input class="form-check-input roleId" type="checkbox" value="${item['id']}" role="switch" id="${item['name']}">
                    <label class="form-check-label" for="${item['name']}">${item['name']}</label>
                </div>
            `;
                    roles.append(row);
                });

            } catch (e) {
                hideLoader();
                unauthorized(e.response?.status);
                $("#Roles").empty().append(`<p class="text-danger">Failed to load permissions</p>`);
            }
        }

        async function Save() {
            try {
                let name = document.getElementById('name').value;
                let phone = document.getElementById('phone').value;
                let email = document.getElementById('email').value;
                let password = document.getElementById('password').value;
                let passkey = document.getElementById('passkey').value;
                let status = document.getElementById('status').value;
                let roleId = [];
                // Correctly select all checked permission checkboxes
                let roleIdList = document.querySelectorAll('.roleId:checked');
                // Loop through the selected checkboxes and push their values
                roleIdList.forEach(function (item) {
                    roleId.push(item.value);
                });
                if (name === "") {
                    errorToast("Name is required");
                }else if(email === "") {
                    errorToast("Email Address is required");
                }else if(phone === "") {
                    errorToast("Phone Number is required");
                }else if(password === "") {
                    errorToast("Password is required");
                }else if(passkey === "") {
                    errorToast("Passkey is required");
                }else if(roleId.length === 0) {
                    errorToast("Role is required");
                }else{
                    showLoader();
                    let res = await axios.post("/SecureDataControls/create-users", {
                        name: name,
                        email: email,
                        phone: phone,
                        password: password,
                        passkey: passkey,
                        roleId: roleId,
                        status: status
                    });

                    hideLoader();

                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        document.getElementById('user-create-close').click();
                        document.getElementById("save-form").reset();
                        await getList();
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            } catch (e) {
                unauthorized(e.response.status);
            }
        }


        //------------Update User
        // Fill Up Update Form
        async function FillUpUpdateForm(id) {
            try {
                document.getElementById('updateID').value = id;
                showLoader();
                // Fetch user data, roles, and the roles the user has
                let res = await axios.post("/SecureDataControls/user-by-id", { id: id });
                let roleData = await axios.get("/SecureDataControls/get-roles");
                let userRoles = await axios.post("/SecureDataControls/get-user-roles-by-id", { id: id });
                document.getElementById('updateName').value = res.data['data']['name'];
                document.getElementById('updateEmailAddress').value = res.data['data']['email'];
                document.getElementById('updatePhone').value = res.data['data']['phone'];
                document.getElementById('updateStatus').value = res.data['data']['status'];
                hideLoader();

                let rolesContainer = $("#updateRole");
                rolesContainer.empty();

                if (roleData.data['data'].length === 0) {
                    rolesContainer.append(`<p class="text-muted">No roles available</p>`);
                    return;
                }

                // Loop through all available roles and append them to the container
                roleData.data['data'].forEach(function (item) {
                    let row = `
                <div class="form-check form-switch">
                    <input class="form-check-input updateRoleId" type="checkbox" value="${item['name']}" role="switch" id="update_${item['name']}">
                    <label class="form-check-label" for="update_${item['name']}">${item['name']}</label>
                </div>
            `;
                    rolesContainer.append(row);
                });
                // Loop through the user's assigned roles and mark the corresponding checkboxes as checked
                userRoles.data['data'].forEach(function (role) {
                    // Check the checkbox for each role that the user has
                    document.getElementById('update_' + role).checked = true;
                });

            } catch (e) {
                unauthorized(e.response.status);
            }
        }
        // Update Function
        async function Update() {
            try {
                let name = document.getElementById('updateName').value;
                let email = document.getElementById('updateEmailAddress').value;
                let phone = document.getElementById('updatePhone').value;
                let password = document.getElementById('updatePassword').value;
                let passkey = document.getElementById('updatePasskey').value;
                let status = document.getElementById('updateStatus').value;
                let id = document.getElementById('updateID').value;
                let roleId = [];
                // Correctly select all checked permission checkboxes
                let roleIdList = document.querySelectorAll('.updateRoleId:checked');
                // Loop through the selected checkboxes and push their values
                roleIdList.forEach(function (item) {
                    roleId.push(item.value);
                });
                if (name === "") {
                    errorToast("Name is required");
                }else if (email === "") {
                    errorToast("Email Address is required");
                }else if (phone === "") {
                    errorToast("phone Address is required");
                }else if(roleId.length === 0) {
                    errorToast("Role is required");
                }else {
                    showLoader();
                    let res = await axios.post("/SecureDataControls/update-users", {
                        id: id,
                        name: name,
                        email: email,
                        phone: phone,
                        password: password,
                        passkey: passkey,
                        status: status,
                        roleId: roleId
                    });
                    hideLoader();
                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        document.getElementById('user-update-close').click();
                        document.getElementById("update-form").reset();
                        await getList();
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            } catch (e) {
                unauthorized(e.response.status);
            }
        }


        //------------Delete User
        async  function  itemDelete(){
            try {
                let id=document.getElementById('deleteID').value;
                document.getElementById('delete-modal-close').click();
                showLoader();
                let res=await axios.post("/SecureDataControls/user-delete-by-id",{id:id});
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
