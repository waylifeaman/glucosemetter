<!DOCTYPE html>
<html>

<head>
    <title>MQTT Messages</title>
</head>

<body>
    <h1>MQTT Messages</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Message</th>
                <th>Received At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->topic }}</td>
                    <td>{{ $message->message }}</td>
                    <td>{{ $message->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
