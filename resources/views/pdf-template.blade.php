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

         /*fronttext*/
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        /*backtext*/
        td {
            background-color: #fff;
            color: #555;
        }

        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Report Details</h1>
        <table>
            <tr>
                <th>ID</th>
                <td>{{$report_data->id}}</td>
            </tr>
            <tr>
                <th>Date of Report</th>
                <td>{{$report_data->dateofreport}}</td>
            </tr>
            <tr>
                <th>Report Name</th>
                <td>{{$report_data->vesselname}}</td>
            </tr>
            <tr>
                <th>Department Involved</th>
                <td>{{$report_data->departmentinvolved}}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{$report_data->description}}</td>
            </tr>
            <tr>
                <th>Position</th>
                <td>{{$report_data->rank}}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{$report_data->name}}</td>
            </tr>
        </table>
    </div>
</body>
</html>
