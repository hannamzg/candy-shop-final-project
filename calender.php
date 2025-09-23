<?php require('components/head.inc.php'); ?>
<?php include('components/navbar.inc.php'); ?>

<?php
    require('connect.php');
    function getProgram() {
        global $conn;
        
        $result = $conn->query("SELECT * FROM weekly_program ORDER BY date, time");
        
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; 
        }
    }
    $programData = getProgram();
?>

<!DOCTYPE html>
<html lang="ar" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البرنامج الأسبوعي</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            direction:rtl;
            margin:40px auto;
            background-color: white;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: right;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .diplayNonePhone{
            display:none;
        }
        /* Media query for phones */
        @media only screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                display: none; /* Hide table headers on phones */
                text-align: center;
            }
            td {
                border: none; /* Remove borders for cells on phones */
                border-bottom: 1px solid #ddd; /* Add bottom border for cells on phones */
                position: relative;
                padding-left: 50%; /* Add space for data labels */
                min-height: 40px;

            }
            td:before {
                position: absolute;
                top: 6px; /* Adjust vertical position */
                left: 6px; /* Adjust horizontal position */
                width: 45%; /* Adjust width of data labels */
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label); /* Show data labels */
                font-weight: bold;
            }
            .br{
                margin-bottom: 20px;
                border: solid 1px;
            }
            .diplayNonePhone{
                display:block;
            }
            
        }
    </style>
</head>
<body>
    <div style="    background-image: url(../church/uploads/jeshoots-com-pUAM5hPaCRI-unsplash.jpg);
    background-position: center;
    background-size: cover;
    object-fit: cover;
    height: 100vh;">
        <h1 style="direction: rtl;text-align: center;padding-top: 20px;">البرنامج الأسبوعي</h1>
        <table>
            <thead>
                <tr>
                    <th >العنوان</th>
                    <th>الوصف</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>الموقع</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programData as $item) : ?>
                    <tr>
                        <td data-label="العنوان"><?= $item['title']; ?></td>
                        <td data-label="الوصف"><?= $item['description']; ?></td>
                        <td data-label="التاريخ"><?= $item['date']; ?></td>
                        <td data-label="الوقت"><?= $item['time']; ?></td>
                        <td data-label="الموقع"><?= $item['location']; ?></td>
                    </tr>
                    <tr class="diplayNonePhone">
                        <td colspan="5" style="padding-left: 0%;">
                            <div class="br"></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
    
            </tbody>
        </table>
    </div>
</body>
</html>
