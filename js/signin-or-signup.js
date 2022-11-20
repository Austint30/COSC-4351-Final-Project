var modalContainer;

class SignInSignUpModal extends PopUp {

    loginHTML = '';
    signUpHTML = 'Work in progress!';
    onSuccessCallback = null;

    setOnSuccessCallback(callback){
        this.onSuccessCallback = callback;
    }

    async getLoginComponent(){

        if (this.loginHTML){
            return this.loginHTML;
        }

        let result = await fetch('components/login.php');
        this.loginHTML = await result.text();
        return this.loginHTML;
    }

    setUpRefs(){
        // Set up references to form elements of login and signup to prevent them from changing the page
        // when being submitted

        this.loginForm = document.getElementById('login-form');
    }

    // override
    afterRenderContent(){
        this.setUpRefs();
        this.attachEventListeners();
    }

    /**
     * Handle submission of login prompt
     * @param {SubmitEvent} e 
     */
    handleLoginSubmit(e){

        let formData = new FormData(this.loginForm);

        fetch('api/auth/login.php', {
            method: 'POST',
            cors: 'same-origin',
            body: formData
        })
        .then(async (resp) => {
            if ([403, 400].includes(resp.status)){
                // Login form has errors. Rerender the form.
                let html = resp.text();
                this.loginHTML = html;
                this.render();
            }
            else
            {
                if (this.onSuccessCallback){
                    this.onSuccessCallback();
                }
            }
        })
    }

    attachEventListeners(){
        // Attach event listers to forms
        this.loginForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent form from submitting.
            this.handleLoginSubmit(e);
        })

        let contWoAccountBtn = document.getElementById('cont-without-account-btn');
        contWoAccountBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (this.onSuccessCallback){
                this.onSuccessCallback();
            }
        })
    }
    
    // override
    async renderContent(){
        let loginHTML = await this.getLoginComponent();

        return`
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center lead sign-in-popup-header text-light" style="display: block;">
                    <div class="flex-1">Make reservations quicker and easier with<br> a ${GLOBAL_COMPANY_NAME} account</div>
                </div>
                <div class="modal-body text-center">
                    
                        <div class="d-flex justify-content-center mb-3" id="sign-in-tab">
                            <ul class="nav nav-pills d-flex align-items-center">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-light active" data-toggle="tab" href="#login-tab">Sign In</a>
                                </li>
                                <span class="mx-3">or</span>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-light" data-toggle="tab" href="#signup-tab">Sign Up</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card container mb-3" style="max-width: 600px;">
                            <div class="tab-content" id="signin-content">
                                <div class="tab-pane fade show active card-body" id="login-tab">
                                    ${loginHTML}
                                </div>
                                <div class="tab-pane fade card-body" id="signup-tab">
                                    ${this.signUpHTML}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100 text-center">
                        <a id="cont-without-account-btn" href="#">Continue without account</a>
                    </div>
                </div>
            </div>
        </div>
        `;
    }
}