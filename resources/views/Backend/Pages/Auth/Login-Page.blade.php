@section('title', 'Login')
@extends('Backend.Layouts.App')
@section('content')
    @include('Backend.Components.Auth.Login-Content')
@endsection
@section('scripts')
    <script>
        // Login Function
        async function Login() {
            // Get Input Values
            let phone = document.getElementById('phone').value;
            let password = document.getElementById('password').value;
            // check validations
            if(phone.length===0){
                errorToast("Mobile number is required");
            }
            else if(password.length===0){
                errorToast("Password is required");
            }
            else{
                showLoader();
                // Send Request
                let res=await axios.post("/SecureDataControls/login",{phone:phone, password:password});
                hideLoader();
                // Handle Response
                if(res.status===200 && res.data['status']==='success'){
                    successToast(res.data['message']);
                    // Redirect to Passkey Page
                    setTimeout(function(){
                        window.location.href="/secure-control/passkey";
                    },1000);
                }
                else{
                    // Show Error Message
                    errorToast(res.data['message']);
                }
            }
        }
    </script>
@endsection

