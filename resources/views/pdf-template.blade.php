<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #2E8B57; /* Dark Sea Green */
            font-weight: bold;
            color: #fff; /* White */
            border-radius: 5px 0 0 5px;
        }

        td {
            background-color: #F0FFF0; /* Honeydew */
            color: #555;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .description-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .description {
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .description th {
            vertical-align: bottom;
        }

        .description td {
            word-wrap: break-word;
            max-width: 100%;
            white-space: pre-wrap; /* Allows text to wrap */
        }

        /* Modern Button Style */
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="color: #2E8B57;">Report Details</h1>
        <table>
            <tr>
                <th>ID</th>
                <td>{{$report_data->id}}</td>
            </tr>
            <tr>
                <th>Date of Report</th>
                <td>{{$report_data->Date_of_report}}</td>
            </tr>
            <tr>
                <th>Report Name</th>
                <td>{{$report_data->Report_name}}</td>
            </tr>
            <tr>
                <th>Report Type</th>
                <td>{{$report_data->Report_type}}</td>
            </tr>
            <tr>
                <th>Department Involved</th>
                <td>{{$report_data->Department_involved}}</td>
            </tr>
        </table>
    </div>

    <!-- Description Section -->
    <div class="description-container">
        <h2 style="color: #333; text-align: center;">Description</h2>
        <table class="description">
            <tr>
                <td>{{$report_data->Description}}</td>
            </tr>
        </table>
    </div>
</body>
</html>
