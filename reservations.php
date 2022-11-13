<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>


<div class="container page-body" style="max-width: 800px">
    <h5 class="border-bottom pb-3 lead text-center">RESERVE A TABLE</h5>
    <!-- Form starts here -->
    <form action="" method="post">
        <!-- Restaurant selection field-->
        <div>
            <label for="restaurant-select">Select Location</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.restaurant;');
                echo'<select id="restaurant-select" class="form-control">';
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
                <label for="name">Name</label>
                <input id="name" name="name" class="form-control">
                <br>
            </div>

            <!-- Phone Number input field-->
            <div class="col-sm">
                <label for="phonenumber">Phone Number</label>
                <input type="tel" id="phonenumber" name="phonenumber" class="form-control">
                <br>
            </div>
        </div>
        <div class="row">
            <!-- Email input field-->
            <div class="col-sm">
                <label for="emailaddress">Email Address</label>
                <input type="email" id="emailaddress" name="emailaddress" class="form-control">
                <br>
            </div>

            <!-- Num Guests input field-->
            <div class="col-sm">
                <label for="numguests">Number Of Guests</label>
                <input type="number" min="0" id="numguests" name="numguests" class="form-control" value="0">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <label>Reservation Date</label>
                <!-- Date input field -->
                <input id="reservation-date" type="date" class="form-control input-sm" id="date" name="date"/>
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
    resTimeBody = document.getElementById("reservation-times-body");
    resTimeCont = document.getElementById("reservation-times-container");
    resDateInput = document.getElementById("reservation-date");
    // $resTime = document.getElementById("reservation-time");
    restInput = document.getElementById("restaurant-select");
    numGuestsInput = document.getElementById("numguests");
    
    resDateInput.addEventListener('input', callApi);
    // $resTime.addEventListener('input', callApi);
    restInput.addEventListener('input', callApi);
    numGuestsInput.addEventListener('input', callApi);

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
        if (!resDateInput.value || !restInput.value){
            resTimeCont.hidden = true;
            return;
        }
        else
        {
            resTimeCont.hidden = false;
            resTimeBody.innerHTML = '<span class="lead text-center">Finding available times...</span>';
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

    /*function callApi(){
        if (!$resDateInput.value || !$resTime.value || !$restInput.value){
            $resTimeBody.hidden = true;
            return;
        }
        else
        {
            $resTimeBody.hidden = false;
            $resTimeBody.innerHTML = '<span class="lead text-center">Finding available tables...</span>';
        }

        

        fetch('api/tables/get-available-tables.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                date: $resDateInput.value,
                time: $resTime.value,
                rest_id: $restInput.value
            })
        })
        .then(async resp => {
            const data = await resp.json();
            console.log(data);

            let dt = new Date(`${$resDateInput.value}T${$resTime.value}`);
            console.log(dt);

            let dtString = dt.toLocaleDateString(undefined, {
                weekday: 'long',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            })

            let content = `<h5 class="card-title mx-3">Tables available at ${dtString}</h5>
            <ul class="list-group list-group-flush">`;

            data.forEach(item => {
                content += `<li class="list-group-item">${item.num_seats} seat tables: ${item.num_tables}</li>`;
            })

            content += '</ul>';

            $resTimeBody.innerHTML = content;
        })
    }*/

    
</script>

<?php include_once 'include/page-end.php' ?>