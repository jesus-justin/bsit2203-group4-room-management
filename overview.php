<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Overview</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            padding: 30px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }
        h2 {
            color: #0072ff;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 80%;
            max-width: 900px;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #0072ff;
            color: white;
            font-size: 1.2em;
        }
        .vacant {
            background-color: #d4edda;
            color: #155724;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
        }
        .occupied {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
        }
        .pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 5px;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-button {
            padding: 12px 30px;
            background-color: #0072ff;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 25px;
            margin-bottom: 20px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .back-button:hover {
            background-color: #0056c1;
            transform: translateY(-5px);
        }
        .back-button:active {
            transform: translateY(2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>

    
    <a href="dashboard.php" class="back-button">Back to Dashboard</a>

    <h2>Room Status Overview</h2>
    <table>
        <tr>
            <th>Room</th>
            <th>Building</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>101</td>
            <td>CICS/TSB</td>
            <td><span class="vacant">Vacant</span></td>
        </tr>
        <tr>
            <td>102</td>
            <td>CICS/TSB</td>
            <td><span class="occupied">Occupied</span></td>
        </tr>
        <tr>
            <td>103</td>
            <td>HEB/VMB</td>
            <td><span class="pending">Pending</span></td>
        </tr>
        <tr>
            <td>104</td>
            <td>GZB</td>
            <td><span class="vacant">Vacant</span></td>
        </tr>
        <tr>
            <td>201</td>
            <td>OB</td>
            <td><span class="occupied">Occupied</span></td>
        </tr>
    </table>

</body>
</html>
