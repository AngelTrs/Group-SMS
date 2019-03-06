<?php
require_once 'config.php';
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Bootstrap Form Helpers -->
    <link href="css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <title>incoming messages</title>

    <style type="text/css">
        td {
            font-size: 12px;
        }

        .bb td, .bb th {
            border-bottom: 1px solid black !important;
        }
    </style>
</head>
<body onLoad="window.scroll(0, document.body.scrollHeight)">
<div class="container-fluid">
    <table class="table table-sm" style="bottom-border=1px;">
        <tbody>

        <?php
        $stmt = $pdo->query('SELECT FROM_NUMBER, BODY, DATETIME, FIRST_NAME, LAST_NAME  FROM incoming_sms LEFT JOIN subscribers ON FROM_NUMBER=MOBILE_NUMBER ORDER BY DATETIME');
        foreach ($stmt as $row) {
            $f_msg_date = date("m/d/y g:i A", strtotime($row['DATETIME']));
            $name = $row['FIRST_NAME'] . " " . $row['LAST_NAME'];
            if ($name == " ") $name = $row['FROM_NUMBER'];
            ?>
            <tr class="bb">
                <td>
                    <small><i><?php echo $name; ?> <?php echo $f_msg_date; ?></i></small>
                    <br><?php echo $row['BODY']; ?></td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
            integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
            crossorigin="anonymous"></script>

</div>
</body>
</html>
