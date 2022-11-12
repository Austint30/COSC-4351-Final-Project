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
        <label>Date and Time</label>
        <div class="input-group">
            <!-- Date input field -->
            <input id="reservation-date" type="date" class="form-control input-sm" id="date" name="date"/>
    
            <!-- making gap 0 -->
            <span class="input-group-btn" style="width:0px;"></span>
    
            <!-- Time input field -->
            <input id="reservation-time" type="time" class="form-control input-sm" id="time" name="time"/>
            <br>
        </div>

        <div id="available-tables" class="my-3 p-2 card">

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
    $availTbWrapper = document.getElementById("available-tables");
    $resDate = document.getElementById("reservation-date");
    $resTime = document.getElementById("reservation-time");
    $restSelect = document.getElementById("restaurant-select");
    
    $resDate.addEventListener('input', callApi);
    $resTime.addEventListener('input', callApi);
    $restSelect.addEventListener('input', callApi);

    callApi();

    function callApi(){
        if (!$resDate.value || !$resTime.value || !$restSelect.value){
            $availTbWrapper.hidden = true;
            return;
        }
        else
        {
            $availTbWrapper.hidden = false;
            $availTbWrapper.innerHTML = '<span class="lead text-center">Finding available tables...</span>';
        }

        

        fetch('api/tables/get-available-tables.php', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                date: $resDate.value,
                time: $resTime.value,
                rest_id: $restSelect.value
            })
        })
        .then(async resp => {
            const data = await resp.json();
            console.log(data);

            let dt = new Date(`${$resDate.value}T${$resTime.value}`);
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

            $availTbWrapper.innerHTML = content;
        })
    }

    
</script>

<?php include_once 'include/page-end.php' ?>