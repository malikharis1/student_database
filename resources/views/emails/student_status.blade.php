<!DOCTYPE html>
<html>

<head>
    <title>Account Status Update</title>
</head>

<body>
    <p>Dear {{ $student->name }},</p>

    <p>Your student account has been <strong>{{ $statusText }}</strong>.</p>

    <p>If you have any questions, feel free to contact our support.</p>

    <p>Regards,<br>
        Student Helpdesk Team</p>
    </p>
</body>

</html>