var modalContainer;

class SignInSignUpModal extends PopUp {

    async getLoginComponent(){
        let result = await fetch('components/login.php');
        let html = await result.text();
        return html;
    }

    setUpRefs(){
        // Set up references to form elements of login and signup to prevent them from changing the page
        // when being submitted

        this.loginForm = document.getElementById('login-form');
    }

    // override
    afterRenderContent(){
        this.setUpRefs();
    }

    /**
     * Handle submission of login prompt
     * @param {SubmitEvent} e 
     */
    handleLoginSubmit(e){
        
    }

    attachEventListeners(){
        // Attach event listers to forms
        this.loginForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent form from submitting.
            this.handleLoginSubmit(e);
        })
    }
    
    // override
    async renderContent(){
        let loginHTML = await this.getLoginComponent();
        return`
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center lead sign-in-popup-header text-light" style="display: block;">
                    <div class="flex-1">Create reservations quicker and easier by<br> creating a ${GLOBAL_COMPANY_NAME} account</div>
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
                                    Sign up
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100 text-center">
                        <a href="#">Continue without account</a>
                    </div>
                </div>
            </div>
        </div>
        `;
    }
}