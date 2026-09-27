<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .summary-card {
            background-color: #e8f4f8;
            border-left: 5px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 1.1em;
            font-weight: bold;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #34495e;
            color: white;
            white-space: nowrap;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        /* Styling baris stok kritis */
        .table-danger {
            background-color: #ffcccc !important;
            color: #990000;
        }
        .table-warning {
            background-color: #fff3cd !important;
            color: #856404;
        }
        /* Badge Status / Kategori */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }
        .badge-tech { background-color: #0d6efd; }
        .badge-apparel { background-color: #6f42c1; }
        .badge-home { background-color: #20c997; }
        .badge-accessories { background-color: #fd7e14; }
        .badge-default { background-color: #6c757d; }
        
        .debug-box {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .debug-box h3 {
            margin-top: 0;
            color: #f39c12;
            border-bottom: 1px solid #555;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= APP_NAME ?></h1>
