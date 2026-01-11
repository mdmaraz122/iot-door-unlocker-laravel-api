@section('title', 'Unlock Logs')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Logs.list')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            GetLogs();
        });
        //------------Get List
        async function getList() {
            try {
                let user_id = document.getElementById('users').value;
                if(!user_id){
                    errorToast("Please select a user");
                    return;
                }
                showLoader();
                let res = await axios.post("/SecureDataControls/get-user-logs", {user_id: user_id});
                hideLoader();

                let tableList = $("#tableList");
                let tableData = $("#tableData");

                tableData.DataTable().destroy();
                tableList.empty();

                res.data['data'].forEach(function (item, index) {
                    let row = `<tr>
                <td>${index + 1}</td>
                <td>${item['user']['name']} - ${item['user']['phone']}</td>
                <td>${formatDate(item['created_at'])}</td>

                </tr>`;
                    tableList.append(row);
                });
                successToast("User history loaded successfully");

                new DataTable('#tableData', {
                    order: [[0, 'desc']],
                    lengthMenu: [5, 10, 15, 20, 30]
                });
            } catch (e) {
                unauthorized(e.response.status);
            }
        }


        //------------Get User Log list
        async function GetLogs() {
            try {
                showLoader();
                let res = await axios.get("/SecureDataControls/get-users");
                hideLoader();

                let users = $("#users");
                users.empty();

                if (res.data['data'].length === 0) {
                    users.append(`<p class="text-muted">No user available</p>`);
                    return;
                }

                res.data['data'].forEach(function (item) {
                    let row = `
                            <option value="${item['id']}">${item['name']} - ${item['phone']}</option>
            `;
                    users.append(row);
                });
            } catch (e) {
                hideLoader();
                unauthorized(e.response?.status);
                $("#Roles").empty().append(`<p class="text-danger">Failed to load user</p>`);
            }
        }
    </script>
@endsection
