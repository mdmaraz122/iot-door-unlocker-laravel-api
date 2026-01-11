@section('title', 'Settings')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Settings.Settings-Content')
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial List Load
            getSetting();
        });
        // Get settings
        async function getSetting(){
            try{
                showLoader();
                let res=await axios.get("/SecureDataControls/settings");
                hideLoader();
                document.getElementById('key').value = res.data['data'][0]['key'];
                document.getElementById('ip_address').value = res.data['data'][0]['ip_address'];
            }catch (e) {
                unauthorized(e.response.status)
            }
        }
        // Update settings
        async function onUpdate(){
            try{
                // Input Values
                let key = document.getElementById('key').value;
                let ip_address = document.getElementById('ip_address').value;
                // Validations
                if(key.length===0){
                    errorToast("Key is required")
                }
                else if(ip_address.length===0){
                    errorToast("IP address is required")
                }else {
                    showLoader();
                    let res = await axios.post("/SecureDataControls/update-setting", {
                        key: key,
                        ip_address: ip_address,
                    });
                    hideLoader();
                    if (res.data['status'] === "success") {
                        successToast(res.data['message']);
                        await getSetting();
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

