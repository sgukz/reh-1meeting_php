<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REH 1Meeting</title>
    <link rel="shortcut icon" href="src/assets/img/new_logo_reh.png" type="image/x-icon">
    <link rel="stylesheet" href="src/assets/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Kanit', sans-serif !important;
            background-color: #CCCCCC;
        }

        .item-center {
            position: fixed;
            left: 50%;
            top: 42%;
            text-align: center;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <span href="#" class="brand-logo">
                <b>REH 1Meeting</b>
            </span>
        </div>
    </nav>
    <div class="row">
        <div class="col s12">
            <div id="profile"></div>
            <div class="card">
                <div class="card-content">
                    <div class="center-align" id="lebel-scan">
                        <strong class="blue-text"><b>กรุณา Scan QR Code เพื่อเข้าร่วมประชุม</b></strong>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-scan">
            <div class="col s12 center-align">
                <input type="hidden" id="userId" value="<?=$_GET["userId"]?>">
                <a class="waves-effect waves-light btn-large pink accent-3 pulse" onclick="scanCode();">
                    <i class="fa fa-qrcode fa-lg" aria-hidden="true"></i><b> SCAN QR Code</b></a>
            </div>
        </div>
    </div>
</body>
<script src="src/assets/js/jquery-3.5.1.min.js"></script>
<script src="src/assets/js/materialize.min.js"></script>
<script src="src/assets/js/main.js"></script>
<script src="src/assets/js/sweetalert2.js"></script>
<script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script>
<script>
    let userID = $("#userId").val();
    function scanCode() {
        liff.scanCode().then((data) => {
            const stringifiedResult = data;
            alert(userID);
            // window.location.href = stringifiedResult.value+"&userId="+userID;
        });
    }

    function getProfileUser() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                $("#userId").val(userId);
            })
    }
    liff.init({
            liffId: "1655384297-Y7egqg67",
        },
        () => {
            getProfileUser();
        }, (err) => alert(err.message)
    );
</script>

</html>