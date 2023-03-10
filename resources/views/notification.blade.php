<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel 8 Firebase Web Push Notification Tutorial</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

    <div class="container" style="margin-top:50px;">

        <div style="text-align: center;">

            <h4>Laravel 8 Firebase Web Push Notification Tutorial</h4>

            <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                class="btn btn-danger btn-xs btn-flat">Click here - Allow Notification</button>
        </div>

        <form action="{{ route('send.notification') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" placeholder="Notification Title" name="title">
            </div>
            <div class="form-group">
                <label for="body">body:</label>
                <input type="text" class="form-control" id="body" placeholder="Notification Body" name="body">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
    var firebaseConfig = {
          apiKey: "AIzaSyBQnwQHe97LTq0PyA-6EkEJxfhY8itQxug",
          authDomain: "hydrolore.firebaseapp.com",
          projectId: "hydrolore",
          storageBucket: "hydrolore.appspot.com",
          messagingSenderId: "245060607925",
          appId: "1:245060607925:web:0c42822440b8e83121c3fc",
          measurementId: "G-HHQYLZSJNB"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        alert('Token saved successfully.');
                    },
                    error: function(err) {
                        console.log('User Chat Token Error' + err);
                    },
                });

            }).catch(function(err) {
                console.log('User Chat Token Error' + err);
            });
    }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
    </script>

</html>