<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary">
                    <div class="text-center mt-4">
                        <h3>Passkey</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="#" class="needs-validation" novalidate="">
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Secret Code</label>
                                </div>
                                <input id="secret_code" type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="Login()" class="btn btn-custom btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    async function Login() {
        let code = document.getElementById('secret_code').value;
        if(code.length===0){
            errorToast("Secret Code number is required");
        }
        else{
            showLoader();
            let res=await axios.post("/SecureDataControls/passkey",{code:code});
            hideLoader()
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                document.getElementById('notifi').play();
            }
            else{
                errorToast(res.data['message']);
                document.getElementById('notifi').play();
            }
        }
    }
</script>
