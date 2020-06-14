<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        const pusher = new Pusher('3aa9b880c0c031e17a49', {

            authEndpoint: '/channels/authorize',

            cluster: 'ap1',

            encrypted: true,

            auth: {

                headers: {

                    'X-CSRF-TOKEN': this.csrfToken

                }

            }
        });

        var channel = pusher.subscribe('class');
        channel.bind('test.created', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>
</body>
