var modalContainer;

class SignInSignUpModal extends PopUp {

    loginHTML = '';
    signUpHTML = '';
    onSuccessCallback = null;
    lastTab = 'login-tab';

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

    async getSignUpComponent(){

        if (this.signUpHTML){
            return this.signUpHTML;
        }

        let result = await fetch('components/signup.php');
        this.signUpHTML = await result.text();
        return this.signUpHTML;
    }

    setUpRefs(){
        // Set up references to form elements of login and signup to prevent them from changing the page
        // when being submitted

        this.loginForm = document.getElementById('login-form');
        this.signUpForm = document.getElementById('signup-form');
    }

    // override
    afterRenderContent(){
        this.setUpRefs();
        this.attachEventListeners();
        if (refreshSignUpUiEventListeners){
            refreshSignUpUiEventListeners();
        }
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
                let html = await resp.text();
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

    /**
     * Handle submission of signup prompt
     * @param {SubmitEvent} e 
     */
     handleSignUpSubmit(e){

        let formData = new FormData(this.signUpForm);

        fetch('api/auth/signup.php', {
            method: 'POST',
            cors: 'same-origin',
            body: formData
        })
        .then(async (resp) => {
            if ([403, 400].includes(resp.status)){
                // Login form has errors. Rerender the form.
                let html = await resp.text();
                this.signUpHTML = html;
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

        this.signUpForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent form from submitting.
            this.handleSignUpSubmit(e);
        })

        let contWoAccountBtn = document.getElementById('cont-without-account-btn');
        contWoAccountBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (this.onSuccessCallback){
                this.onSuccessCallback();
            }
        })

        let loginTab = document.getElementById('login-tab-link');
        let signupTab = document.getElementById('signup-tab-link');

        loginTab.addEventListener('click', (e) => {
            this.lastTab = 'login-tab';
            this.render();
        })

        signupTab.addEventListener('click', (e) => {
            this.lastTab = 'signup-tab';
            this.render();
        })
    }
    
    // override
    async renderContent(){
        let loginHTML = await this.getLoginComponent();
        let signUpHTML = await this.getSignUpComponent();

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
                                    <a id="login-tab-link" class="nav-link btn btn-light ${this.lastTab === 'login-tab' ? 'active' : ''} data-toggle="tab" href="#login-tab">Sign In</a>
                                </li>
                                <span class="mx-3">or</span>
                                <li class="nav-item">
                                    <a id="signup-tab-link" class="nav-link btn btn-light" ${this.lastTab === 'signup-tab' ? 'active' : ''} data-toggle="tab" href="#signup-tab">Sign Up</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card container mb-3" style="max-width: 600px;">
                            <div class="tab-content" id="signin-content">
                                <div class="tab-pane fade ${this.lastTab === 'login-tab' ? 'show active' : ''} card-body" id="login-tab">
                                    ${loginHTML}
                                </div>
                                <div class="tab-pane fade ${this.lastTab === 'signup-tab' ? 'show active' : ''} card-body" id="signup-tab">
                                    ${signUpHTML}
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