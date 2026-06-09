<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .query-box {
            background-color: #fff;
            padding: 15px;
            border-left: 4px solid #8a2be2;
            margin: 15px 0;
            font-style: italic;
        }

        .admin-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #8a2be2;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .admin-link:hover {
            background-color: #6a1b9a;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>You got a query from <strong>{{ str_replace(' - Customer', '', $ticket->open_by) }}</strong> ({{ $ticket->email }}).</p>
        
        <p>Query on this order: <strong>{{ $ticket->subject }}</strong></p>

        <p>The query is:</p>
        <div class="query-box">
            {{ $ticket->description }}
        </div>

        <a href="{{ route('admin.tickets.all') }}" class="admin-link" style="color: #ffffff;">Go to Admin Panel</a>
    </div>
</body>

</html>
