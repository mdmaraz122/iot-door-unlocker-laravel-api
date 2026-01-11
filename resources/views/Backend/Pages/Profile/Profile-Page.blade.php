@section('title', 'Profile')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Profile.Profile-Form')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            getProfile();
        });
        // Get Profile
        async function getProfile(){
            try{
                showLoader();
                let res=await axios.get("/SecureDataControls/user-profile");
                hideLoader();
                document.getElementById('name').value = res.data['data']['name'];
                document.getElementById('email').value = res.data['data']['email'];
                document.getElementById('phone').value = res.data['data']['phone'];
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // Update Profile
        async function onUpdate(){
            try{
                // Input Values
                let name = document.getElementById('name').value;
                let email = document.getElementById('email').value;
                let phone = document.getElementById('phone').value;
                // Validations
                if(name.length===0){
                    errorToast("Name is required")
                }
                else if(email.length===0){
                    errorToast("Email Address is required")
                }
                else if(phone.length===0){
                    errorToast("Mobile Number is required")
                }else {
                    showLoader();
                    let res = await axios.post("/SecureDataControls/update-profile", {
                        name: name,
                        email: email,
                        phone: phone,
                    });
                    hideLoader();
                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        await getProfile();
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // update Password
        async function onUpdatePassword(){
            try{
                // Input Values
                let current_password = document.getElementById('current_password').value;
                let new_password = document.getElementById('new_password').value;
                let confirm_password = document.getElementById('confirm_password').value;
                // Validations
                if(current_password.length===0){
                    errorToast("Current Password is required")
                }
                else if(new_password.length===0){
                    errorToast("New Password is required")
                }
                else if(new_password.length < 6){
                    errorToast("New Password must be at least 6 characters")
                }
                else if(confirm_password.length===0){
                    errorToast("Confirm Password is required")
                }
                else if(new_password!==confirm_password){
                    errorToast("New Password and Confirm Password must be same")
                }else {
                    showLoader();
                    let res = await axios.post("/SecureDataControls/update-password", {
                        current_password: current_password,
                        new_password: new_password,
                        confirm_password: confirm_password,
                    });
                    hideLoader();
                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        document.getElementById('current_password').value = "";
                        document.getElementById('new_password').value = "";
                        document.getElementById('confirm_password').value = "";
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // update Passkey
        async function onUpdatePasskey(){
            try{
                // Input Values
                let current_passkey = document.getElementById('current_passkey').value;
                let new_passkey = document.getElementById('new_passkey').value;
                let confirm_passkey = document.getElementById('confirm_passkey').value;
                // Validations
                if(current_passkey.length===0){
                    errorToast("Current Passkey is required")
                }
                else if(new_passkey.length===0){
                    errorToast("New Passkey is required")
                }
                else if(new_passkey.length < 6){
                    errorToast("New Passkey must be at least 6 characters")
                }
                else if(confirm_passkey.length===0){
                    errorToast("Confirm Passkey is required")
                }
                else if(new_passkey!==confirm_passkey){
                    errorToast("New Passkey and Confirm Passkey must be same")
                }else {
                    showLoader();
                    let res = await axios.post("/SecureDataControls/update-passkey", {
                        current_passkey: current_passkey,
                        new_passkey: new_passkey,
                        confirm_passkey: confirm_passkey,
                    });
                    hideLoader();
                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        document.getElementById('current_passkey').value = "";
                        document.getElementById('new_passkey').value = "";
                        document.getElementById('confirm_passkey').value = "";
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
    </script>
@endsection

