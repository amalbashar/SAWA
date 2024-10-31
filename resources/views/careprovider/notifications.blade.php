<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notifications</title>
</head>
<body>
    <h1>Your Notifications</h1>

    @if($notifications->count() > 0)
        <ul>
            @foreach($notifications as $notification)
                <li>
                    {{ $notification->data['message'] ?? 'No message' }} <br>
                    Received: {{ $notification->created_at->diffForHumans() }}<br>
                    @if(is_null($notification->read_at))
                        <span style="color: red;">Unread</span>
                    @else
                        <span style="color: green;">Read</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No new notifications</p>
    @endif

</body>
</html>
