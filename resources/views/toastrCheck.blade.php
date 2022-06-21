<!DOCTYPE html>
<html>

<head>
    <title>MISAS ALERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    @include('toastr')
    <section id="loader">
        <div class="d-flex align-items-center">
            <strong class="m-5">Waiting for incoming alert...</strong>
            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
        </div>
    </section>
    <div class="container mt-5">

        <div class="row" id="load">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5>Dashboard</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="select">Select User</h5>
                        <audio autoplay>
                            <source src="audio/beep.mp3" type="audio/beep.mp3">>
                        </audio>
                        <form>
                            <select required id="user" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value='{"id": "user"}'  >Select User</option>
                                @forelse($users as $user)
                                <option value='{"id":{{$user->id}}, "location": {{ $user->location }}, "role": {{ $user->role }} }'> {{ $user->username }} </option>
                                @empty
                                <option value=""> No users </option>
                                @endforelse
                            </select>
                        </form>
                        <div>
                            <button onclick="userType()" class="btn btn-success"> Submit </button>
                            <i class="bg-light" id="btn1" onclick="playAudio()"></i>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <!-- <div class="container"> -->

    <div class="clo-12 te">
        <div class="row">
            <div class="d-flex align-items-center">
                <button id="btn" class="btn btn-primary m-5 " onclick="hideLoad()" style="position:absolute; bottom:0">Change User</button>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function hideLoad() {
            $('#btn').hide();
            document.getElementById('load').style.display = 'block';
        }

        function userType() {
            let user = JSON.parse(document.getElementById('user').value);
            console.log('user json', user);

            if (user.id =='user') {
                toastr.warning('Please select a user');
                return;
            }
            // JSON.parse(user);

            localStorage.setItem('user', JSON.stringify(user.id));
            localStorage.setItem('location', JSON.stringify(user.location));
            localStorage.setItem('role', JSON.stringify(user.role));
            toastr.success(`User ${user.id} selected`);
            console.log('id', user);
            $("#loader").show();
            // $("#load").hide();
            $("#btn").show();
            // location.reload();
            document.getElementById('load').style.display = 'none';
        }

        function playAudio() {
            new Audio('/audio/beep.mp3').play();
        }

        $(function() {
            $('#loader').hide();
            $("#btn").hide();


            var intervalId = window.setInterval(function() {
                    let user = JSON.parse(localStorage.getItem('user'));
                    let location = JSON.parse(localStorage.getItem('location'));
                    let role = JSON.parse(localStorage.getItem('role'));
                    console.log('user ', typeof(user));

                    if (user == null) {
                        toastr.error('Please select user to receive notification');
                        return
                    }

                    //new patient
                    $.ajax({
                        url: "/patient",
                        type: "GET",
                        data: {
                            user_id: user
                        },
                        success: function(data) {
                            let newPatient = JSON.parse(localStorage.getItem('patient'));
                            console.log('data new Patient', data);
                            if (data.patients > newPatient?.patients || newPatient == null) {
                                localStorage.setItem('patient', JSON.stringify(data));
                                if (user == data.user_id) {
                                    $('#btn1').trigger('click');
                                    toastr.success(
                                        'A New Patient on your queue'); // success message popup notification
                                    console.log('response');
                                }
                            }

                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });



                    //new message
                    $.ajax({
                        url: "/message",
                        type: "GET",
                        data: {
                            user_id: user
                        },
                        success: function(data) {
                            // alert('dispensed')
                            let newMessage = JSON.parse(localStorage.getItem('message'));
                            console.log('data new message', data);
                            if (data.message > newMessage?.message || newMessage == null) {
                                localStorage.setItem('message', JSON.stringify(data));
                                if (user == data.user_id) {
                                    $('#btn1').trigger('click');
                                    toastr.success(
                                        'You have new message'); // success message popup notification
                                    console.log('message');
                                }
                            }

                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });



                    //new Result
                    $.ajax({
                        url: "/result",
                        type: "GET",
                        data: {
                            user_id: user
                        },
                        success: function(data) {
                            let newResult = JSON.parse(localStorage.getItem('result'));
                            console.log('data new Result', data);
                            if (data.result > newResult?.result || newResult == null) {
                                localStorage.setItem('result', JSON.stringify(data));
                                if (user == data.user_id) {
                                    $('#btn1').trigger('click');
                                    toastr.success(
                                        'A Patient Result is ready '); // success message popup notification
                                    console.log('new Result');
                                }
                            }
                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });


                    //check billings
                    $.ajax({
                        url: "/check",
                        type: "GET",
                        data: {
                            location: location,
                        },
                        success: function(data) {
                            let newBilling = JSON.parse(localStorage.getItem('billings'));
                            console.log('data new Billing', data);
                            if (data.billings > newBilling?.billings || newBilling == null) {
                                localStorage.setItem('billings', JSON.stringify(data));
                                if (role == 5) {
                                    $('#btn1').trigger('click');
                                    toastr.success(`${data.role_5_message}`); // success message popup notification
                                    console.log('new Billing');
                                }
                                if (role == 3) {
                                    $('#btn1').trigger('click');
                                    toastr.success(`${data.role_3_message}`); // success message popup notification
                                }
                            }
                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });


                    //new incoming billings request
                    $.ajax({
                        url: "/billings",
                        type: "GET",
                        data: {
                            location: location,
                        },
                        success: function(data) {
                            let newBillings_request = JSON.parse(localStorage.getItem('billings_request'));
                            console.log('data new Billings_request', data);
                            if (data.billings_request > newBillings_request?.billings_request || newBillings_request == null) {
                                localStorage.setItem('billings_request', JSON.stringify(data));
                                if (role == 6) {
                                    $('#btn1').trigger('click');
                                    toastr.success(`${data.message}`); // success message popup notification
                                    console.log('new Billings_request');
                                }
                            }
                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });


                    //new  prescription
                    $.ajax({
                        url: "/prescription",
                        type: "GET",
                        data: {
                            location: location,

                        },
                        success: function(data) {
                            let newPrescription = JSON.parse(localStorage.getItem('prescription'));
                            console.log('data new Prescription', data);
                            if (data.prescriptions > newPrescription?.prescriptions || newPrescription == null) {
                                localStorage.setItem('prescription', JSON.stringify(data));
                                if (role == 4) {
                                    $('#btn1').trigger('click');
                                    toastr.success(`${data.message}`); // success message popup notification
                                    console.log('new Prescription');
                                }
                            }
                        },
                        error: function(data) {
                            console.log('data error', data);
                        }
                    });





                },
                5000);
            // window.clearInterval(intervalId);
        });

        // clear interval
    </script>


</body>

</html>