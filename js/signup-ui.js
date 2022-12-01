let billingEl = document.getElementById('signup-billing-address');
let mailSameBillEl = document.getElementById('signup-mail-same-billing');

function refreshSignUpUiEventListeners(){
    billingEl = document.getElementById('signup-billing-address');
    mailSameBillEl = document.getElementById('signup-mail-same-billing');

    if (billingEl && mailSameBillEl){
        addSignUpUiEventListeners();
        onSameAsBillingClicked();
    }
}

refreshSignUpUiEventListeners();

function addSignUpUiEventListeners(){
    mailSameBillEl.removeEventListener('click', onSameAsBillingClicked);
    mailSameBillEl.addEventListener('click', onSameAsBillingClicked);
}

function onSameAsBillingClicked(){
    if (mailSameBillEl.checked){
        billingEl.setAttribute("disabled", "");
    }
    else if (billingEl.hasAttribute("disabled")){
        billingEl.removeAttribute("disabled");
    }
}