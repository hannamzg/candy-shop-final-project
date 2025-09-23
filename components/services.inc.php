<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        #gradient {
            position: relative;
            background-image: url('https://as1.ftcdn.net/v2/jpg/02/14/09/82/1000_F_214098258_VC0lJWUY5DWjqsnHF8JgYCrGy84MLcfh.jpg');
            width: 100%;
            min-height: 250px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            filter: brightness(95%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Custom Styles */
        .dropdown-toggle::after {
            display: none; /* Hide the default caret */
        }

        .dropdown-toggle::before {
            content: "\f0d7"; /* Font Awesome caret (or any other icon/character you prefer) */
            font-family: "Font Awesome 5 Free"; /* Set the correct font family for the caret */
            font-weight: 900; /* Make the caret bold */
            margin-right: 10px; /* Space between the caret and the text */
            margin-left: 10px;
            display: inline-block; /* Make it behave like an inline element */
        }

        /* Ensure the dropdown button behaves properly */
        .dropdown-toggle {
            width: 100%; /* Make the button full width */
            text-align: left; /* Align text to the left */
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; /* Custom background */
            color: black; /* Set text color to black */
            border: 1px solid #333; /* Border color */
            box-shadow: none; /* Remove shadow */
        }

        .headerTextDiv {
            text-align: center;
            background-color:  white; /* Darker background for header */
            padding: 15px;
            border-radius: 10px;
            color: rgba(0, 0, 0, 0.7); /* White text for header */
            margin: 20px auto;
        }

        .dropdown-item {
            cursor: pointer;
            color: black; /* Change dropdown item text color to black */
        }

        .dropdown-item:hover,
        .dropdown-item:active {
            background-color: #333; /* Dark background on hover for dropdown items */
            color: black; /* Keep text black on hover */
        }

        .dropdown-item:focus {
            background-color: #333;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .question-item {
            cursor: pointer;
            margin-bottom: 10px;
            padding: 10px;
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; /* Custom background */
            border: 1px solid #333; /* Border color */
            border-radius: 5px;
            display: flex;
            justify-content: right;
            align-items: center;
            color: black; /* Set text color to black */
        }

        .question-item:hover {
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; /* Same background on hover */
            color: black; /* Ensure text stays black on hover */
        }

        .card {
            margin-top: 20px;
        }

        .question-title {
            font-size: 1.25rem;
        }

        .icon {
            transition: transform 0.3s;
        }

        .icon.rotated {
            transform: rotate(180deg);
        }

        /* Full Width Dropdown */
        .dropdown-toggle {
            width: 100%; /* Make the button full width */
            text-align: left; /* Align text to the left */
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; /* Custom background */
            color: black; /* Set text color to black */
            border: 1px solid #333; /* Border color */
            box-shadow: none; /* Remove shadow */
        }

        .dropdown-menu {
            width: 100%; /* Make the dropdown menu full width */
            left: 0; /* Align dropdown menu to the left */
            top: 100%; /* Position dropdown below the button */
            z-index: 1;
        }

        /* Ensure dropdown does not change on hover or active */
        .dropdown-toggle:hover,
        .dropdown-toggle:active {
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; /* Same background */
            color: black; /* Keep text black */
        }

        .dropdown-item:hover, .dropdown-item:active{
            background-color: transparent !important;
            color: black !important;
        }

    </style>
</head>
<?php require('GetClient.php');?>
<body>
    <!-- Header Section -->
    <header class="page-header gradient" id="gradient"></header>

    <!-- Main Container -->
    <div class="container" style='height: 100vh;'>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header Text Div -->
                <div class="headerTextDiv">
                    <h1 class="headerText"> 
                        <?php
                            if ($clientID == 1) {
                                echo "اسئلة وأجوبة عن المسيحية";
                        
                            }else{
                                echo "שאלות נפוצות";
                            }
                        ?>
                    </h1>
                </div>

                <!-- List of Questions as Dropdowns -->
                <div id="questions-list">
                    <?php
                        require('connect.php');
                        $sql = "SELECT * FROM questions WHERE client_id = $clientID";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $question_id = $row['id'];
                                echo "<div class='dropdown'>
                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton-{$question_id}' >
                                            <li>
                                                <a class='dropdown-item' href='#' style='text-align: end; background-color: white !important; display: block; overflow: hidden;'>
                                                    <p style='margin: 0; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: normal;'>
                                                        " . htmlspecialchars($row['option1']) . "
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                        <button class='btn bg-dark dropdown-toggle question-item' type='button' id='dropdownMenuButton-{$question_id}' aria-expanded='false' style='direction: rtl;'>
                                            <strong>" . htmlspecialchars($row['question_text']) . "</strong>
                                        </button>
                                      </div>";
                            }
                        } else {
                            echo "<p>No questions available.</p>";
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Bootstrap dropdown JS functionality
        document.addEventListener('DOMContentLoaded', function () {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function (dropdown) {
                dropdown.addEventListener('click', function (event) {
                    var menu = this.previousElementSibling;
                    if (menu.classList.contains('show')) {
                        menu.classList.remove('show');
                    } else {
                        document.querySelectorAll('.dropdown-menu').forEach(function (openMenu) {
                            openMenu.classList.remove('show');
                        });
                        menu.classList.add('show');
                    }
                });
            });

            // Automatically close the dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
</body>

</html>
