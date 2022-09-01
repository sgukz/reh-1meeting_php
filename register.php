<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | REH 1Meeting</title>
    <link rel="shortcut icon" href="src/assets/img/new_logo_reh.png" type="image/x-icon">
    <link rel="stylesheet" href="src/assets/css/materialize.min.css">
    <link rel="stylesheet" href="src/assets/css/style.css">
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
    <div class="loading" id="loading">Loading&#8230;</div>
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
                                            <h3 class="blue-text">Register</h3>
                                            <h6 class="grey-text"><b>Please fill out the information completely.</b></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-user prefix"></i>
                                            <input type="hidden" id="userId" name="userId" value="">
                                            <input type="hidden" id="docno" value="<?= $_GET["docno"] ?>">
                                            <input id="fullname" name="fullname" type="text" class="validate" required>
                                            <label for="fullname">Fullname</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-bars prefix"></i>
                                            <input id="position" name="position" type="text" class="validate" required>
                                            <label for="position">Position</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-bars prefix"></i>
                                            <input id="depart_name" name="depart_name" type="text" class="validate" required>
                                            <label for="depart_name">Department</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-phone prefix"></i>
                                            <input id="phone" name="phone" type="text" class="validate" required>
                                            <label for="phone">Phone</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="fa fa-building prefix"></i>
                                            <input id="main_company" name="main_company" type="text" class="validate" required>
                                            <label for="main_company">Government</label>
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
                                        <i class="fa fa-save"></i> Save
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
<script src="src/assets/js/jquery.validate.min.js"></script>
<script src="src/assets/js/main.js"></script>
<script src="src/assets/js/sweetalert2.js"></script>
<script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script>
<script>
    let meetingId = $("#docno").val();
    let base_url = "https://api.reh.go.th:9000";
    let today = new Date().getTime();

    $("#form_register").submit((e) => {
        $.ajax({
                method: "POST",
                url: `${base_url}/saveRegister`,
                data: $("#form_register").serialize(),
                beforeSend: function(e) {
                    $("#preloader").removeClass("hidden");
                    $("#loading").removeClass("hidden");
                    $("#btn_submit_regis").addClass("disabled");
                }
            })
            .done((resp) => {
                let data = resp
                if (data.code === 200) {
                    $("#loading").addClass("hidden");
                    let timerInterval
                    Swal.fire({
                        title: "Registered successfully",
                        text: "waiting...",
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location = "https://liff.line.me/1657432903-V1Aolerg?docno=" + meetingId;
                        }
                    })
                } else {
                    $("#loading").addClass("hidden");
                    Swal.fire({
                        'icon': "error",
                        'title': data.msg,
                        'text': JSON.stringify(data.data)
                    })
                }
            })
            .fail((error) => {
                console.log(error);
            })
        e.preventDefault();
    });

    function getProfileUser() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                $("#userId").val(userId);
                $.ajax({
                        method: "GET",
                        url: `${base_url}/checkUser/${userId}`,
                        data: ""
                    })
                    .done((resp) => {
                        let data = resp
                        if (data.code === 200) {
                            $("#loading").addClass("hidden");
                            let timerInterval
                            Swal.fire({
                                title: "You are registered",
                                text: "waiting...",
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location = "https://liff.line.me/1657432903-V1Aolerg?docno=" + meetingId;
                                }
                            })
                        } else if (data.code === 400) {
                            $("#loading").addClass("hidden");
                        }
                    })
                    .fail((error) => {
                        alert(JSON.stringify(error))
                        console.log(error);
                    })
            })
    }
    liff.init({
            liffId: "1657432903-bGRepN3d",
        },
        () => {
            getProfileUser();
        }, (err) => console.log(err.message)
    );
</script>

</html>