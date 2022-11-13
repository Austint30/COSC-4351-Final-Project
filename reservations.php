<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>

<?php

    $session_name = $_SESSION["name"] ?? "";
    $session_email = $_SESSION["email"] ?? "";

?>


<div class="container page-body" style="max-width: 800px">
    <h5 class="border-bottom pb-3 lead text-center">RESERVE A TABLE</h5>
    <!-- Form starts here -->
    <form action="" method="post">
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
        <div>
            <p class="text-danger">Please note that on high traffic days a $10 holding fee will be placed, and returned upon arrival. If you do not show up then it is not refunded</p>
        </div>

        <!-- Showing how many of which table is available  NEEDS TO BE DONE-->
        <div>
        </div>

        <!-- Reserve button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Reserve</button>  
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

    function onResTimeChosen(time){
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
    }

    function clearChosenTime(){
        renderTimes();
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

        times.forEach(([ time, tables ]) => {
            let dt = new Date(`${resDateInput.value}T${time}`);
            let timeStr = dt.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: 'numeric'
            })

            content += `<button
                id="res-time-${time}"
                type="button"
                class="btn btn-outline-primary"
                onclick="onResTimeChosen('${time}')"
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
    
</script>

<?php include_once 'include/page-end.php' ?>