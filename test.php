<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REH 1Meeting</title>
    <link rel="shortcut icon" href="src/assets/img/new_logo_reh.png" type="image/x-icon">
</head>

<body>

</body>
<script src="src/assets/js/jquery-3.5.1.min.js"></script>
<script>
    $.ajax({
            method: "GET",
            url: `https://api.reh.go.th:9000/checkUser/Ue0ff435b2479f94c48476b266403b867`,
        })
        .done((resp) => {
            alert(JSON.stringify(resp))
        })
        .fail(err => {
            alert(JSON.stringify(err))
        })
</script>

</html>