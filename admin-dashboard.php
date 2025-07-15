<?php
// --- Basic Auth Setup ---
$valid_passwords = ["admin" => "123456"];
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'] ?? '';
$pass = $_SERVER['PHP_AUTH_PW'] ?? '';

$validated = isset($valid_passwords[$user]) && $valid_passwords[$user] === $pass;

if (!$validated) {
    header('WWW-Authenticate: Basic realm="RSVP Admin"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Access Denied";
    exit;
}

// --- Read JSON Data ---
$data = [];
$file = 'responses.json';

if (file_exists($file)) {
    $json = file_get_contents($file);
    $data = json_decode($json, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RSVP Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>

<div class="container dashboard-container">
    <div class="text-center mb-4">
        <h2 class="font-weight-bold">RSVP Dashboard</h2>
        <p class="text-muted">Guest submissions overview</p>
    </div>

    <?php if (empty($data)): ?>
        <div class="alert alert-warning text-center">No submissions yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Attendance</th>
                        <th>Guest Count</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $entry): ?>
                        <tr>
                            <td><?= htmlspecialchars($entry['name']) ?></td>
                            <td><?= htmlspecialchars($entry['attendance']) ?></td>
                            <td><?= htmlspecialchars($entry['guestCount']) ?></td>
                            <td><?= htmlspecialchars($entry['submittedAt'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
