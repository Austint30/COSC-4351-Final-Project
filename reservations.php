<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>

<?php

    $session_name = $_SESSION["name"] ?? "";
    $session_email = $_SESSION["email"] ?? "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $successMsg = "Reservation submitted";

        header("Location: /post-reservation.php");
        exit;
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
    <form action="reservations.php" method="post">
        <!-- Restaurant selection field-->
        <div>
            <label for="restaurant-select" class="required-asterisk">Select Location</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.restaurant;');
                echo'<select id="restaurant-select" class="form-control" required>';
                echo '<option value="">Select a restaurant</option>';
                while ($row = $query->fetch_assoc()){
                    echo "<option value='".$row['id']."'>" .$row['street_address'].", ".$row["city"].", ".$row["state"]."</option>";
                }
                
                echo'</select>';
            ?>
            <br>
        </div>
        
        <div class="row">
            <!-- Name input field-->
            <div class="col-sm">
                <label for="name" class="required-asterisk">Name</label>
                <input id="name" name="name" class="form-control" value="<?php echo $session_name ?>" required/>
                <br>
            </div>

            <!-- Phone Number input field-->
            <div class="col-sm">
                <label for="phonenumber" class="required-asterisk">Phone Number</label>
                <input type="tel" id="phonenumber" name="phonenumber" class="form-control" required/>
                <br>
            </div>
        </div>
        <div class="row">
            <!-- Email input field-->
            <div class="col-sm">
                <label for="emailaddress" class="required-asterisk">Email Address</label>
                <input type="email" id="emailaddress" name="emailaddress" class="form-control" value="<?php echo $session_email ?>" required/>
                <br>
            </div>

            <!-- Num Guests input field-->
            <div class="col-sm">
                <label for="numguests" class="required-asterisk">Number Of Guests</label>
                <input type="number" min="0" id="numguests" name="numguests" class="form-control" value="1" required>
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
                    class="form-control input-sm"
                    id="date"
                    name="date"
                    required
                    min="<?php echo date('Y-m-d') ?>"
                />
                <br>
            </div>
            <div class="col-sm"></div>
        </div>

        <div id="reservation-times-container" class="mb-3 reservation-times-container">
            <label>Choose an open time slot</label>
            <div id="reservation-times-body" class="reservation-times-body"></div>
        </div>
        
        <!-- Fee warning -->
        <div id="fee-warning"></div>

        <!-- Showing how many of which table is available  NEEDS TO BE DONE-->
        <div>
        </div>

        <!-- Reserve button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Reserve</button>  
        </div>

        <!-- Credit Card input field -->
        <div class="mb-3">
            <label for="ccNumber" class="form-label">Credit Card Number</label>
            <input class="form-control" id="ccNumber" placeholder="0000000000000000"/>
        </div>

        <!-- Check if CC number is valid button-->
        <div class="mb-3">
            <input type="button" class="btn btn-primary" value="Check" onClick="checkCC()"/>
        </div>

        <!-- Display if CC number is valid or not-->
        <div class="mb-3">
            <label for="ccDisplay" class="form-label">Is it valid?</label>
                <textarea disabled="true" class="form-control" id="ccValidator" rows="3" style="font-size: 25px"></textarea>
        </div>

    </form>
</div>

<script>
    const debouncedCallApi = debounce(callApi);

    resTimeBody = document.getElementById("reservation-times-body");
    resTimeCont = document.getElementById("reservation-times-container");
    resDateInput = document.getElementById("reservation-date");
    restInput = document.getElementById("restaurant-select");
    numGuestsInput = document.getElementById("numguests");
    feeWarningCont = document.getElementById("fee-warning");
    
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
        const inputDate = new Date(resDateInput.value+'T00:00');

        if (inputDate < today) {
            resDateInput.value = today.toISOString().split('T')[0]
        }
    })

    resDateInput.addEventListener('input', debouncedCallApi);

    times = null;

    callApi();

    function onResTimeChosen(time, isHighTraffic){
        let dt = new Date(`${resDateInput.value}T${time}`);
        let timeStr = dt.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: 'numeric'
            })
        resTimeBody.innerHTML = `<span>
            <input readonly hidden id="reservation-time" name="reservation-time" value="${time}" />
            <div class="form-control" style="max-width: 100px;display: inline-block;">${timeStr}</div>
            <button id="clear-reservation" onclick="clearChosenTime();" type="button" class="btn btn-link">Clear</button>
        </span>`;

        if (isHighTraffic){
            feeWarningCont.innerHTML = `<p class="text-danger">Please note that on high traffic days a $10 holding fee will be placed, and returned upon arrival. If you do not show up then it is not refunded</p>`;
        }
    }

    function clearChosenTime(){
        renderTimes();
        feeWarningCont.innerHTML = '';
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
        let content = '<div class="reservation-times-grid">';

        if (times.length == 0){
            content += '<div class="lead text-center">No times available</div>';
        }

        times.forEach(([ time, tables, perc_avail ]) => {
            let dt = new Date(`${resDateInput.value}T${time}`);
            let timeStr = dt.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: 'numeric'
            })

            let btnClass = "btn-outline-primary";
            let tooltip = "";

            let isHighTraffic = perc_avail < 0.5;

            if (isHighTraffic){
                btnClass = "btn-outline-danger";
                tooltip = "High traffic time (less than 50% tables available)";
            }

            content += `<button
                id="res-time-${time}"
                type="button"
                class="btn ${btnClass}"
                onclick="onResTimeChosen('${time}', ${isHighTraffic})"
                title="${tooltip}"
            >${timeStr}</li>`;
        })

        content += '</div';
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
            renderTimes();
        })
    }

    //This is the luhnAlgorithm function which checks if a CC number is valid or not.
    const luhnAlgorithm = (ccNumber) => {
        const cclength = ccNumber.length;
        let count = 0;

        //Loop through ccNumber. Starts at the beginning of the number and begins doubling from the first number.
        if(cclength % 2 == 0)
        {
            for(let i = 0; i < cclength; i++)
            {
                let currDigit = parseInt(ccNumber[i]);
                if (i % 2 == 0) // I only want to double every other number, starts doubling with the second-to-last number. I don't want to double the last number.
                {
                    if ((currtDigit *= 2) > 9)
                    {
                        // Separate the number into component parts and then add them together.
                        let trailingNumber = currDigit % 10;
                        let firstNumber = parseInt(currDigit / 10);

                        // If currentDigit was 18 then currentDigit is now 9.
                        currDigit = firstNumber + trailingNumber;
                    }
                }
                
                count += currDigit;
            }
        }
        else {
            //this is same thing but for odd len cards such as american express
            for(let i = cclength - 1 ; i >= 0; i--)
            {
                let currDigit = parseInt(ccNumber[i]);
                if ((i - 1) % 2 == 0) // I only want to double every other number, starts doubling with the second-to-last number. I don't want to double the last number.
                {
                    if ((currDigit *= 2) > 9)
                    {
                        // Separate the number into component parts and then add them together.
                        let trailingNumber = currDigit % 10;
                        let firstNumber = parseInt(currDigit / 10);

                        // If currentDigit was 18 then currentDigit is now 9.
                        currDigit = firstNumber + trailingNumber;
                    }
                }
                
                count += currDigit;
            }
        }

        return (count % 10) === 0;
    }

    const checkCC = () => { //this function is called by button, eventually need it to be called automatically
        const ccNumber = document.getElementById("ccNumber");
        const ccValidation = document.getElementById("ccDisplay");
        let message = "";

        //Calling the Luhn Algo
        if( luhnAlgorithm(ccNumber.value))
            message = "Credit Card is VALID";
        else
            message = "Credit Card in INVALID";

        //Make the ccDisplay = to the message variable which is blank initially
        elCCValidation.textContent = message;
        //Clears ccNumber field.
        elCCNumber.value = null;
    }
</script>

<?php include_once 'include/page-end.php' ?>