@section('title', 'Users')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Passkey.Passkey-Content')
@endsection
@section('scripts')
    <script>
        async function Unlock() {
            let passkey = document.getElementById('passkey').value;
            if(passkey.length===0){
                errorToast("Passkey is required");
            }
            else{
                showLoader();
                let res=await axios.post("/SecureDataControls/passkey",{passkey:passkey});
                hideLoader()
                if(res.status===200 && res.data['status']==='success'){
                    successToast(res.data['message']);
                    document.getElementById('passkey').value = "";
                }
                else{
                    errorToast(res.data['message']);
                }
            }
        }
    </script>
@endsection
