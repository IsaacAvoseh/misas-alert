<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        $.ajax({
            url: "/show",
            type: "GET",
            // data: {
            //     search: value
            // },
            success: function(data) {},
            error: function(data) {
                console.log('data error', data);
            }
        });

        $.ajax({
            url: "/check",
            type: "GET",
            // data: {
            //     search: value
            // },
            success: function(data) {
                let old_billing_count = JSON.parse(localStorage.getItem(
                    'old_billing_count'));

                if (old_billing_count?.billing_count == null || data.billing_count >
                    old_billing_count.billing_count) {
                    localStorage.setItem('old_billing_count', JSON.stringify(data));


                    if (role == 5) {
                        $('#btn1').trigger('click');
                        // var response = JSON.(data);
                        toastr.success(
                            'New Billing request'); // success message popup notification
                        console.log('response');
                        console.log('role', role);
                        // return
                    } else if (role == 3) {
                        $('#btn1').trigger('click');
                        // var response = JSON.(data);
                        toastr.success(
                            'New Patient'
                        ); // success message popup notification
                        console.log('response');
                        console.log('role', role);

                        // return

                    } else {
                        return
                    }

                }

                // audio.autoplay = "true"
            },
            error: function(data) {
                console.log('data error', data);
            }
        });

        // let approved_count = JSON.parse(localStorage.getItem('approved_count'));

        $.ajax({
            url: "/approved",
            type: "GET",
            // data: {
            //     search: value
            // },
            success: function(data) {
                let approved = JSON.parse(localStorage.getItem(
                    'approved_count'));
                console.log('approve data ', data)

                console.log("approv confirm this firtd", approved)


                if (data?.approved > approved?.approved || approved == null) {
                    localStorage.setItem('approved_count', JSON.stringify(data));
                    if (role == 5) {
                        $('#btn1').trigger('click');
                        toastr.success(
                            'New Patient Checked In'); // success message popup notification
                        console.log('response');
                        console.log('role', role);
                    }
                }

            },
            error: function(data) {
                console.log('data error', data);
            }
        });


        //check dispense 

        $.ajax({
            url: "/dispensed",
            type: "GET",
            // data: {
            //     search: value
            // },
            success: function(data) {
                // alert('dispensed')
                let dispensed = JSON.parse(localStorage.getItem('dispense'));
                console.log('data dispensed', data);
                if (data.dispensed > dispensed?.dispensed || dispensed == null) {
                    localStorage.setItem('dispense', JSON.stringify(data));
                    if (role == 7) {
                        $('#btn1').trigger('click');
                        toastr.success(
                            'A New Result is Ready'); // success message popup notification
                        console.log('response');
                        console.log('role', role);
                    }
                }

            },
            error: function(data) {
                console.log('data error', data);
            }
        });
    </script>
</body>

</html>