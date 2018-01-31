<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Somos 21</title>
    <link rel="stylesheet" href="components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="components/jquery/dist/jquery.js"></script>
    <script src="components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="components/typeahead/typeahead.js"></script>
    <script src="components/js/util.js"></script>

    <style>
        h1 {
            font-size: 20px;
            color: #111;
        }

        .content {
            width: 80%;
            margin: 0 auto;
            margin-top: 50px;
        }

        .tt-hint,
        .city {
            border: 2px solid #CCCCCC;
            border-radius: 8px 8px 8px 8px;
            font-size: 24px;
            height: 45px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 400px;
        }

        .tt-dropdown-menu {
            width: 400px;
            margin-top: 5px;
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px 8px 8px 8px;
            font-size: 18px;
            color: #111;
            background-color: #F1F1F1;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('input.city').typeahead({
                name: 'city',
                remote: 'skillsearch.php?query=%QUERY'

            });

        })
    </script>
</head>

<body>
    <div class="content">

        <form>
            <h1>Try it yourself</h1>
            <input type="text" name="city" size="30" class="city" placeholder="Please Enter City or ZIP code">
        </form>
    </div>
</body>

</html>