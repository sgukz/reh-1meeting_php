<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน | REH 1Meeting</title>
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
                    <div id="section-form-register">
                        <form id="form_register">
                            <div class="row center-align">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6 class="blue-text"><b>กรุณากรอกข้อมูลให้ครบถ้วน</b></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-user prefix"></i>
                                            <input type="text" id="userId" name="userId" value="<?= (isset($_GET["userId"]) ? $_GET["userId"] : "") ?>">
                                            <input id="fullname" name="fullname" type="text" class="validate" required>
                                            <label for="fullname">ชื่อ - สกุล</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-bars prefix"></i>
                                            <input id="position" name="position" type="text" class="validate" required>
                                            <label for="position">ตำแหน่ง</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-bars prefix"></i>
                                            <input id="depart_name" name="depart_name" type="text" class="validate" required>
                                            <label for="depart_name">หน่วยงาน</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-phone prefix"></i>
                                            <input id="phone" name="phone" type="text" class="validate" required>
                                            <label for="phone">เบอร์โทร</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-building prefix"></i>
                                            <input id="main_company" name="main_company" type="text" class="validate" required>
                                            <label for="main_company">ส่วนราชการ</label>
                                        </div>
                                    </div>
                                    <div class="preloader-wrapper small active hidden" id="preloader">
                                        <div class="spinner-layer spinner-blue-only">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="gap-patch">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                    &nbsp;&nbsp;
                                    <button id="btn_submit_regis" class="btn waves-effect waves-light pink accent-3" type="submit">
                                        <i class="fa fa-save"></i> บันทึก
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
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
    $(document).ready(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const meeting_id = urlParams.get('docno')
        const userID = urlParams.get('userId')
        const page = urlParams.get('page')
        let base_url = "https://service-api-1meeting.herokuapp.com";
        let today = new Date().getTime();

        $("#form_register").submit((e) => {
            $.ajax({
                    method: "POST",
                    url: `${base_url}/saveRegister`,
                    data: $("#form_register").serialize(),
                    beforeSend: function(e) {
                        $("#preloader").removeClass("hidden");
                        $("#btn_submit_regis").addClass("disabled");
                    }
                })
                .done((resp) => {
                    let data = resp
                    if (data.code === 200) {
                        Swal.fire({
                            'icon': "success",
                            'title': "ลงทะเบียนเรียบร้อย",
                            'text': "กรุณารอสักครู่...",
                            'showConfirmButton': false,
                        })
                        setTimeout(() => {
                            window.location = `?docno=${meeting_id}`;
                        }, 1000)
                    } else {
                        Swal.fire({
                            'icon': "error",
                            'title': data.msg,
                            'text': data.data
                        })
                    }
                })
                .fail((error) => {
                    console.log(error);
                })
            e.preventDefault();
        });
    });

    function getProfileUser() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                alert(userId);
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