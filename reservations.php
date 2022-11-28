<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>
<?php include_once 'include/reservation/get-available-tables-at-times.php' ?>
<?php include_once 'include/reservation/create-reservation.php' ?>
<?php include_once 'include/form.php' ?>
<?php include_once 'include/global.php' ?>

<?php

    $session_name = $_SESSION["name"] ?? "";
    $session_username = $_SESSION["username"] ?? "";
    $session_email = $_SESSION["email"] ?? "";

    $submissionErrorMsg = null;

    $form_invalid = false;
    $restIdMsg = null;
    $nameMsg = null;
    $phoneMsg = null;
    $emailMsg = null;
    $numGuestsMsg = null;
    $resDateMsg = null;
    $resTimeMsg = null;
    $ccNumberMsg = null;
    $cvvMsg = null;
    $ccExpMonthMsg = null;
    $ccExpYearMsg = null;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // This data is not actually processed.
        // Using this to keep the reservation time consistent if the form is rejected
        $isHighTraffic = $_POST["is-high-traffic"] ?? false;

        $restId = validateNotEmpty("rest-id", $restIdMsg, "Location is required", $form_invalid);
        $name = validateNotEmpty("name", $nameMsg, "Name is required", $form_invalid);
        $phone = validateNotEmpty("phonenumber", $phoneMsg, "Phone Number is required", $form_invalid);
        if($phoneMsg === null){
            $phone = validatePhone("phonenumber", $phoneMsg, "Phone Number is in an invalid format.", $form_invalid);
        }

        $phone = filterPhoneNumber($phone);

        $email = validateNotEmpty("emailaddress", $emailMsg, "Email is required", $form_invalid);
        if ($emailMsg === null){
            $email = validateEmail("emailaddress", $emailMsg, "Email is in an invalid format.", $form_invalid);
        }

        $numGuests = validateNotEmpty("numguests", $numGuestsMsg, "Number Of Guests is required", $form_invalid);

        // Validate that the number of guests is a valid number between 1 and 20
        if ($numGuestsMsg === null){
            $numGuestsValidator = function($numGuests){

                $invalid = false;

                if (!is_numeric($numGuests)){
                    $invalid = true;
                }

                $numGuests = (int) $numGuests;
                if (!($numGuests >= 1 || $numGuests <= 20)){
                    $invalid = true;
                }

                if ($invalid){
                    return "Number Of Guests must be a valid integer between 1 and 20";
                }
                return "";
            };
            
            $numGuests = validateCustom("numguests", $numGuestsValidator, $numGuestsMsg, $form_invalid);
        }

        $resDate = validateNotEmpty("date", $resDateMsg, "Reservation Date is required", $form_invalid);

        // Validate that the reservation date field is a valid date and is not before today
        if ($resDateMsg === null){

            $resDateValidator = function($dateStr){
                $parsedDate = DateTime::createFromFormat("Y-m-d", $dateStr);
                if ($parsedDate === false){
                    return "Reservation Date is an invalid format (must be YYYY-MM-DD)";
                }
                if ($parsedDate < (new DateTime("now"))->format('Y-m-d')){
                    return "Reservation Date cannot be before today";
                }
            };

            $resDate = validateCustom("date", $resDateValidator, $resDateMsg, $form_invalid);
        }

        // Validate that a Reservation Time is chosen and is actually available to this user
        $resTime = validateNotEmpty("reservation-time", $resTimeMsg, "Reservation Time is required", $form_invalid);

        $isHighTraffic = false;

        if ($resTimeMsg === null){
            $resTimeValidator = function($timeStr) use ($resDate, $restId, $numGuests, $resTime, &$isHighTraffic){
                $times = getAvailTablesAtTimes($resDate, $restId, (int) $numGuests);
                foreach ($times as $item) {
                    $time = $item[0];
                    $highTraffic = $item[3];
                    if ($time === $resTime){
                        if ($highTraffic === true){
                            $isHighTraffic = true;
                        }
                        return "";
                    }
                }
                return "This time is no longer available";
            };

            $resTime = validateCustom("reservation-time", $resTimeValidator, $resTimeMsg, $form_invalid);
        }

        // If a reservation time is given that is high traffic, validate credit card.
        if ($isHighTraffic){
            $ccNumber = validateNotEmpty("ccNumber", $ccNumberMsg, "Credit Card Number is required", $form_invalid);

            if ($ccNumberMsg === null){
                $ccNumber = validateCreditCard("ccNumber", $ccNumberMsg, "Credit Card Number is INVALID", $form_invalid);
            }

            $cvv = validateNotEmpty("cvv", $cvvMsg, "CVV is required", $form_invalid);

            if ($cvvMsg === null){
                $cvv = validateCVV("cvv", $cvvMsg, "Please type a valid CVV", $form_invalid);
            }

            $ccExpMonth = validateNotEmpty("ccMonth", $ccExpMonthMsg, "Month is required", $form_invalid);

            if ($ccExpMonthMsg === null){
                $ccExpMonth = validateMonth("ccMonth", $ccExpMonthmsg, "Please type 1-12", $form_invalid);
            }

            $ccExpYear = validateNotEmpty("ccYear", $ccExpYearMsg, "Year is required", $form_invalid);

            if ($ccExpMonthMsg === null){
                $ccExpYear = validateYear("ccYear", $ccExpYearMsg, "Please type a valid year in the format YYYY", $form_invalid);
            }
        }

        if (!$form_invalid){
            $resOpt = new ReservationOptions();
            $resOpt->name = $name;
            $resOpt->email = $email;
            $resOpt->rest_id = (int) $restId;
            $resOpt->phone = $phone;
            $resOpt->num_guests = $numGuests;
            $resOpt->res_date = $resDate;
            $resOpt->res_time = $resTime;
            $resOpt->cc_number = $ccNumber ?? "";
            $resOpt->cc_cvv = $cvv ?? "";
            $resOpt->cc_exp_month = $ccExpMonth ?? "";
            $resOpt->cc_exp_year = $ccExpYear ?? "";
            $resOpt->user_id = $session_username;

            try{
                $new_res_id = createReservation($resOpt);
            }
            catch(ReservationException $e){
                $submissionErrorMsg = $e.getMessage();
            }

            if (!$submissionErrorMsg){
                header("Location: /post-reservation.php?res_id=".$new_res_id);
                exit;
            }
        }
    }

?>


<div class="container page-body" style="max-width: 800px">
    <h5 class="border-bottom pb-3 lead text-center">RESERVE A TABLE</h5>

    <?php

        if (isset($successMsg)){
            echo '<div class="alert alert-success">'.$successMsg.'</div>';
        }

    ?>
    

    <!-- Form starts here -->
    <form id="reservation-form" method="post">
        <?php

            if ($submissionErrorMsg){
                echo '<div class="alert alert-danger mb-3">Failed to submit reservation: '.$submissionErrorMsg.'</div>';
            }

            if ($form_invalid){
                echo '<div class="alert alert-danger mb-3">We found some issues with your form. Please correct the items highlighted in red.</div>';
            }
        ?>
        <!-- Restaurant selection field-->
        <div>
            <label for="restaurant-select" class="required-asterisk">Select Location</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.restaurant;');
                echo'<select name="rest-id" id="restaurant-select" class="form-control '.($restIdMsg ? "is-invalid" : "").'" value="'.($restId ?? '').'" required>';
                echo '<option value="">Select a restaurant</option>';
                while ($row = $query->fetch_assoc()){
                    echo "<option ";
                    if ($row['id'] === ($restId ?? '')){
                        echo "selected ";
                    }
                    echo "value='".$row['id']."'>" .$row['street_address'].", ".$row["city"].", ".$row["state"]."</option>";
                }
                
                echo'</select>';

                renderErrorFeedback($restIdMsg ?? null)
            ?>
            <br>
        </div>
        
        <div class="row">
            <!-- Name input field-->
            <div class="col-sm">
                <label for="name" class="required-asterisk">Name</label>
                <input id="name" name="name" class="form-control <?php echo $nameMsg ? "is-invalid" : "" ?>" value="<?php echo ($name ?? null) ?? $session_name ?>" required/>
                <?php renderErrorFeedback($nameMsg ?? null) ?>
                <br>
            </div>

            <!-- Phone Number input field-->
            <div class="col-sm">
                <label for="phonenumber" class="required-asterisk">Phone Number</label>
                <input type="tel" id="phonenumber" name="phonenumber" class="form-control <?php echo $phoneMsg ? "is-invalid" : "" ?>" value="<?php echo $phone ?? '' ?>" required/>
                <?php renderErrorFeedback($phoneMsg ?? null) ?>
                <br>
            </div>
        </div>
        <div class="row">
            <!-- Email input field-->
            <div class="col-sm">
                <label for="emailaddress" class="required-asterisk">Email Address</label>
                <input type="email" id="emailaddress" name="emailaddress" class="form-control <?php echo $emailMsg ? "is-invalid" : "" ?>" value="<?php echo ($email ?? null) ?? $session_email ?>" required/>
                <?php renderErrorFeedback($emailMsg ?? null) ?>
                <br>
            </div>

            <!-- Num Guests input field-->
            <div class="col-sm">
                <label for="numguests" class="required-asterisk">Number Of Guests</label>
                <input type="number" min="1" id="numguests" name="numguests" class="form-control <?php echo $numGuestsMsg ? "is-invalid" : "" ?>" value="<?php echo $numGuests ?? '1' ?>" required>
                <?php renderErrorFeedback($numGuestsMsg ?? null) ?>
                <small class="form-text text-muted">Max number of guests including yourself: 20</small>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <label class="required-asterisk">Reservation Date</label>
                <!-- Date input field -->
                <input
                    id="reservation-date"
                    type="date"
                    class="form-control input-sm <?php echo $resDateMsg ? "is-invalid" : "" ?>"
                    id="date"
                    name="date"
                    min="<?php echo date('Y-m-d') ?>"
                    value="<?php echo $resDate ?? ''?>"
                    required
                />
                <?php renderErrorFeedback($resDateMsg ?? null) ?>
                <br>
            </div>
            <div class="col-sm"></div>
        </div>
        
        <?php
            if ($resTimeMsg){
                echo '<p class="text-danger">'.$resTimeMsg.'</p>';
            }
        ?>
        <div id="reservation-times-container" class="mb-3 reservation-times-container">
            <label>Choose an open time slot</label>
            <div id="reservation-times-body" class="reservation-times-body"></div>
        </div>

        <div id="cc-number-container">

        </div>
        
        <!-- Fee warning -->
        <div id="fee-warning"></div>

        <!-- Showing how many of which table is available  NEEDS TO BE DONE-->
        <div>
        </div>

        <!-- Reserve button -->
        <div class="text-center">
            <!-- TODO: remove onclick="submitForm();" -->
            <button type="submit" class="btn btn-primary btn-lg">Reserve</button>
        </div>
    </form>
</div>


<script src="js/signin-or-signup.js"></script>
<script src="js/luhn-algorithm.js"></script>
<script>
    let userSignedIn = <?php echo strlen($session_name) > 0 ? "true" : "false"; ?>;

    let resForm = document.getElementById("reservation-form");

    if (!userSignedIn){
        // If user is not signed in display the sign up prompt
        resForm.addEventListener('submit', submitForm);
    }

    let signinPopup = new SignInSignUpModal();

    function handleAfterSignInPopup(){
        resForm.submit();
    }

    function submitForm(e){
        e.preventDefault();
        signinPopup.setOnSuccessCallback(handleAfterSignInPopup);
        signinPopup.show();
    }
</script>

<script>

    const debouncedCallApi = debounce(callApi);

    let resTimeBody = document.getElementById("reservation-times-body");
    let resTimeCont = document.getElementById("reservation-times-container");
    let resDateInput = document.getElementById("reservation-date");
    let restInput = document.getElementById("restaurant-select");
    let numGuestsInput = document.getElementById("numguests");
    let feeWarningCont = document.getElementById("fee-warning");
    let ccNumberCont = document.getElementById("cc-number-container");
    let ccNumberInput = null;
    
    resDateInput.addEventListener('input', debouncedCallApi);
    restInput.addEventListener('input', debouncedCallApi);
    numGuestsInput.addEventListener('input', debouncedCallApi);

    // minmax guests input. Don't allow num of guests to exceed 20 or go below 0
    numGuestsInput.addEventListener('input', () => {
        if (numGuestsInput.value > 20){
            numGuestsInput.value = 20;
        }
        else if (numGuestsInput.value < 1){
            numGuestsInput.value = 1;
        }
    });

    // Prevent user from selecting a date before today
    resDateInput.addEventListener('input', () => {
        let today = new Date();
        console.log(today.getTimezoneOffset());
        const inputDate = new Date(resDateInput.value+'T00:00');

        if (inputDate < today) {
            resDateInput.value = today.toISOString().split('T')[0]
        }
    })

    resDateInput.addEventListener('input', debouncedCallApi);

    times = null;

    callApi();

    const PHP_RESTIME = "<?php echo $resTime ?? 'null' ?>";
    const PHP_IS_HIGH_TRAFFIC = <?php echo ($isHighTraffic ?? false) === true ? "true" : "false" ?>;

    if (PHP_RESTIME){
        onResTimeChosen(PHP_RESTIME, PHP_IS_HIGH_TRAFFIC);
    }

    function onResTimeChosen(time, isHighTraffic){
        console.log(time, isHighTraffic);
        let dt = new Date(`${resDateInput.value}T${time}`);
        let timeStr = dt.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: 'numeric'
            })
        resTimeBody.innerHTML = `<span>
            <input readonly hidden id="reservation-time" name="reservation-time" value="${time}" class="<?php echo $resTimeMsg ? "is-invalid" : "" ?>" />
            <div class="form-control" style="max-width: 100px;display: inline-block;">${timeStr}</div>
            <button id="clear-reservation" onclick="clearChosenTime();" type="button" class="btn btn-link">Clear</button>
            <input readonly hidden id="is-high-traffic" name="is-high-traffic" value="${isHighTraffic}" />
        </span>`;

        if (isHighTraffic){
            feeWarningCont.innerHTML = `<p class="text-danger">Please note that on high traffic days a $10 holding fee will be placed, and returned upon arrival. If you do not show up then it is not refunded</p>`;
            ccNumberCont.innerHTML = `
                <div class="mb-3 row">
                    <div class="col-sm">
                        <label for="ccNumber" class="form-label">Credit Card Number</label>
                        <input class="form-control <?php echo $ccNumberMsg ? "is-invalid" : "" ?>" id="ccNumber" name="ccNumber" autocomplete="cc-number" value="<?php echo $ccNumber ?? '' ?>"/>
                        <div id="ccnumber-feedback-container">
                            <?php renderErrorFeedback($ccNumberMsg ?? null) ?>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col-sm">
                        <div class="mr-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input style="width: 70px;" max="3" class="form-control <?php echo $cvvMsg ? "is-invalid" : "" ?>" id="cvv" name="cvv" autocomplete="cc-csc" value="<?php echo $cvv ?? '' ?>"/>
                            <div id="cvv-feedback-container">
                                <?php renderErrorFeedback($cvvMsg ?? null) ?>
                            </div>
                        </div>
                        <div class="mr-3">
                            <label for="ccMonth" class="form-label">Exp Month</label>
                            <input type="number" min="1" max="12" style="width: 100px;" placeholder="e.g. 11" class="form-control <?php echo $ccExpMonthMsg ? "is-invalid" : "" ?>" id="ccMonth" name="ccMonth" autocomplete="cc-exp-month" value="<?php echo $ccExpMonth ?? '' ?>"/>
                            <div id="ccmonth-feedback-container">
                                <?php renderErrorFeedback($ccExpMonthMsg ?? null) ?>
                            </div>
                        </div>
                        <div>
                            <label for="ccYear" class="form-label">Exp Year</label>
                            <input type="number" min="<?php (new DateTime)->format("Y") ?>" style="width: 120px;" placeholder="e.g. 2024" class="form-control <?php echo $ccExpYearMsg ? "is-invalid" : "" ?>" id="ccYear" name="ccYear" autocomplete="cc-exp-year" value="<?php echo $ccExpYear ?? '' ?>"/>
                            <div id="ccmonth-feedback-container">
                                <?php renderErrorFeedback($ccExpYearMsg ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add event listener to check card validity on input of field
            if (ccNumberInput){
                ccNumberInput.removeEventListener('input', checkCC);
            }
            ccNumberInput = document.getElementById("ccNumber");
            ccNumberInput.addEventListener('input', checkCC);
        }
        else
        {
            feeWarningCont.innerHTML = '';
            ccNumberCont.innerHTML = '';
        }

        // //I don't know if this will work, just experimenting
        // if (isHighTraffic){
        //     ccDisplay.innerHTML = ` 
        //         <div class="mb-3">
        //             <label for="ccDisplay" class="form-label">Is it valid?</label>
        //             <textarea disabled="true" class="form-control" id="ccDisplay" rows="3" style="font-size: 25px"></textarea>
        //         </div>`
        // }
        
    }

    function clearChosenTime(){
        renderTimes();
        feeWarningCont.innerHTML = '';
        ccNumberCont.innerHTML = '';
    }

    function findBestTableCombo(time){
        
    }

    /*function findTableCombination(time){
        let tableArray = times.find((item) => item[0] == time);
        if (!tableArray) return;

        // Sort from largest num seats to smallest
        tableArray.sort((a, b) => b.num_seats - a.num_seats);

        // Filter out table types that have 0 tables left
        tableArray.filter((item) => item.num_tables > 0);

        let prevSeatsLeft = -1;
        let currSeatsLeft = 0;

        while()

        // Find 
        tableArray.forEach(({ num_seats, num_tables }) => {
            const numGuests = numGuestsInput.value;
            
            if (numGuests)
        });
    }*/

    function renderTimes(){
        if (!times) return;
        let content = '<div>';

        if (times.length == 0){
            content += '<div class="lead text-center">No times available</div>';
        }

        if (times[0][4]){
            // If this is a special day, display a message
            content += `<div class="alert alert-warning my-3">We are expecting higher traffic than usual on ${times[0][4]}. $10 holding fee will apply.</div>`;
        }

        content += '<div class="reservation-times-grid">';

        times.forEach(([ time, tables, perc_avail, is_high_traffic, special_day_desc ]) => {
            
            let dt = new Date(`${resDateInput.value}T${time}`);
            let timeStr = dt.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: 'numeric'
            })

            let btnClass = "btn-outline-primary";
            let tooltip = "";

            if (is_high_traffic && !special_day_desc){
                btnClass = "btn-outline-danger";
                tooltip = "High traffic expected at this time";
            }

            content += `<button
                id="res-time-${time}"
                type="button"
                class="btn ${btnClass}"
                onclick="onResTimeChosen('${time}', ${is_high_traffic})"
                title="${tooltip}"
            >${timeStr}</li>`;
        })

        content += '</div></div>';
        resTimeBody.innerHTML = content;
    }

    function callApi(){
        console.log('calling API');
        if (!resDateInput.value || !restInput.value){
            resTimeCont.hidden = true;
            return;
        }
        else
        {
            resTimeCont.hidden = false;
            resTimeBody.innerHTML = '<div class="lead text-center">Finding available times...</div>';
        }

        fetch('api/tables/get-available-tables-at-times.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                date: resDateInput.value,
                rest_id: restInput.value,
                num_guests: Number(numGuestsInput.value)
            })
        })
        .then(async resp => {
            times = await resp.json();
            let renderTimesGrid = true;
            if (times){
                // Check if PHP form reservation time is equal to an available reservation time
                // and automatically choose the time again
                times.forEach(([ time, tables, perc_avail, is_high_traffic ]) => {
                    if (PHP_RESTIME && time === PHP_RESTIME){
                        onResTimeChosen(time, is_high_traffic);
                        renderTimesGrid = false;
                        return;
                    }
                })
            }

            if (renderTimesGrid){
                renderTimes();
            }
        })
    }

    function checkCC ()  { //this function is called by button, eventually need it to be called automatically
        console.log('checkCC called')
        const ccValCont = document.getElementById("ccnumber-feedback-container");
        // const ccValidation = document.getElementById("ccDisplay");
        let feedback = "";

        if (ccNumberInput.value){
            //Calling the Luhn Algo
            if( luhnAlgorithm(ccNumberInput.value))
            {
                ccNumberInput.classList.add("is-valid");
                ccNumberInput.classList.remove("is-invalid");
                feedback = `<div class="valid-feedback" style="display: block;">Credit Card Number is VALID</div>`;
            }
            else
            {
                ccNumberInput.classList.add("is-invalid");
                ccNumberInput.classList.remove("is-valid");
                feedback = `<div class="invalid-feedback" style="display: block;">Credit Card Number is INVALID</div>`;
            }
        }
        else
        {
            ccNumberInput.classList.add("is-invalid");
            ccNumberInput.classList.remove("is-valid");
            feedback = `<div class="invalid-feedback" style="display: block;">Credit Card Number is required</div>`;
        }

        

        //Make the ccDisplay = to the message variable which is blank initially
        ccValCont.innerHTML = feedback;
        //Clears ccNumber field.
        //ccNumber.value = null;
    }
</script>

<?php include_once 'include/page-end.php' ?>