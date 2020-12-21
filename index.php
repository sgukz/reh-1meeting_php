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
                                            <input type="hidden" id="userId" name="userId" value="">
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
                    <div class="center-align" id="lebel-scan">
                        <strong class="blue-text"><b>กรุณา Scan QR Code เพื่อเข้าร่วมประชุม</b></strong>
                    </div>
                    <div class="section hidden" id="section-data">
                        <div id="meeting_name" style="margin-bottom: 15px"></div>
                        <div id="meeting_date"></div>
                        <!--  -->
                        <div id="meeting_time"></div>
                        <!-- <strong >เริ่มประชุมเวลา 12.00น - 16.00น.</strong> -->
                        <div id="meeting_total"></div>
                        <!-- <strong >เข้าประชุมแล้ว 50 คน</strong> -->
                        <br>
                        <div id="is_check_in" class="center-align"></div>
                        <!-- <span class="grey lighten-3 green-text" id="check_in_date">เข้าร่วมประชุมเมื่อ<br> วันที่ 17
                        ธันวาคม 2563 เวลา 16.59น.</span> -->
                        <br>
                        <div class="center-align" id="section_btn_check">
                            <button type="button" id="btn_check_in" class="waves-effect waves-light btn green accent-4"><b>Check-in</b></button>
                            <button type="button" id="btn_check_out" class="waves-effect waves-light btn red darken-3"><b>Check-Out</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-scan">
            <div class="col s12 center-align">
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
    function scanCode() {
        liff.scanCode().then((data) => {
            const stringifiedResult = data;
            alert(stringifiedResult.value)
            // liff
            //     .getProfile()
            //     .then((profile) => {
            //         const userId = profile.userId;
            //         alert(userId)
            //     })
            //     .catch((err) => {
            //         console.log("error", err);
            //     });
        });
    }
    liff.init({
            liffId: "1655384297-Gl97j7de",
        },
        () => {},
        (err) => alert(error.message)

    );
    $(document).ready(function() {
        $()
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const meeting_id = urlParams.get('docno')
        const page = urlParams.get('page')
        let base_url = "https://service-api-1meeting.herokuapp.com";
        // let base_url = "http://localhost:8000";
        const userID = ($("#userId").val() !== "" ? $("#userId").val() : 0);
        let today = new Date().getTime();
        // console.log("userId = " + userID);
        $("#btn_check_in").click(function() {
            saveCheckin(userID, meeting_id, 1);
        });

        $("#btn_check_out").click(function() {
            saveCheckin(userID, meeting_id, 2);
        });

        $("#form_register").submit((e) => {
            // console.log(JSON.stringify());
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

        function checkUser(userId) {
            $.ajax({
                    method: "GET",
                    url: `${base_url}/checkUser/${userId}`,
                    data: ""
                })
                .done((resp) => {
                    let data = resp
                    console.log(data);
                    if (data.code === 200) {
                        setTimeout(() => {
                            window.location = `?docno=${meeting_id}`;
                        }, 1000)
                    } else if (data.code === 400) {
                        setTimeout(() => {
                            window.location = `?docno=${meeting_id}&page=register`;
                        }, 1000)
                    }
                })
                .fail((error) => {
                    console.log(error);
                })
        }

        function saveCheckin(userId, docno, is_check) {
            let data = {
                userId,
                docno,
                is_check,
            };
            $.ajax({
                    method: "POST",
                    url: `${base_url}/saveCheckin`,
                    data: data
                })
                .done((resp) => {
                    let data = resp
                    if (data.code === 200) {
                        Swal.fire({
                            'icon': "success",
                            'title': data.msg,
                            'text': "เรียบร้อย",
                            'showConfirmButton': false,
                        })
                        setTimeout(() => {
                            window.location = `?docno=${data.data}`;
                        }, 1000)
                    }
                })
                .fail((error) => {
                    console.log(error);
                })
        }
        if (meeting_id !== null) {
            if (page !== null) {
                $("#btn_check_in").addClass("hidden");
                $("#section-scan").addClass("hidden");
                $("#lebel-scan").addClass("hidden");
            } else {
                $("#section-form-register").addClass("hidden");
                $.ajax({
                        method: "GET",
                        url: `${base_url}/getMeetingByDocno/${meeting_id}`,
                        data: ""
                    })
                    .done((resp) => {
                        // console.log(resp);
                        if (resp.code === 200) {
                            let data = resp.data[0]
                            let endDate = new Date(data.end_date).getTime();
                            if (today > endDate) {
                                $("#btn_check_in").addClass("hidden");
                                $("#btn_check_out").addClass("hidden");
                                $("#is_check_in").html(`<span class='red-text'><b>จบการประชุมแล้ว</b></span>`);
                            }
                            $("#section-scan").addClass("hidden");
                            $("#lebel-scan").addClass("hidden");
                            $("#section-data").removeClass("hidden");
                            let meeting_name = `<strong style='font-size: 16px;'><b>หัวข้อ : ${data.meeting_name}</b></strong>`;
                            let meeting_date = `<strong>ระหว่างวันที่ <b>${(formateDate(data.start_date) === formateDate(data.end_date) ? formateDate(data.start_date) : formateDate(data.start_date) + " - " + formateDate(data.end_date))}</b></strong>`;
                            let meeting_time = `<strong>เริ่มประชุมเวลา <b> ${formateTime(data.start_date)} - ${formateTime(data.end_date)}</b></strong>`;
                            let meeting_total = `<strong><b>เข้าประชุมแล้ว ${resp.total[0].total_meeting}/${data.human_amount} คน</b></strong>`;
                            $("#meeting_total").html(meeting_total);
                            $("#meeting_name").html(meeting_name);
                            $("#meeting_date").html(meeting_date);
                            $("#meeting_time").html(meeting_time);
                            $.ajax({
                                    method: "GET",
                                    url: `${base_url}/getMeetingRegisByUserID/${data.docno}/${userID}`,
                                    data: ""
                                })
                                .done((resp) => {
                                    // console.log(resp);
                                    let dataRegis = (resp.data !== null) ? resp.data[0] : ""
                                    if (dataRegis !== "") {
                                        let meeting_total = `<strong><b>เข้าประชุมแล้ว ${dataRegis.cntMeeting}/${data.human_amount} คน</b></strong>`;
                                        $("#meeting_total").html(meeting_total);
                                        if (dataRegis.check_in_date !== null) {
                                            $("#btn_check_in").addClass("hidden");
                                            if (dataRegis.check_out_date !== null) {
                                                $("#btn_check_out").addClass("hidden");
                                            }
                                            // $("#btn_check_out").removeClass("hidden");
                                            let is_check_in = `<span class="grey lighten-3 green-text" id="check_in_date">เข้าร่วมประชุมเมื่อ<br> 
                                    วันที่ ${formateDate(dataRegis.check_in_date)} เวลา ${formateTime(dataRegis.check_in_date)}</span>`;
                                            $("#is_check_in").html(is_check_in);
                                        }
                                    }
                                })


                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่พบข้อมูล...',
                                text: 'กรุณาลองใหม่อีกครั้ง',
                            })
                        }
                    })
            }
        } else {
            $("#section-scan").removeClass("hidden");
            $("#section-form-register").addClass("hidden");
            // $("#lebel-scan").removeClass("hidden");
            // $("#section-data").removeClass("hidden");
        }
    });

    function formateDate(dateTime) {
        let thmonth = {
            "01": "มกราคม",
            "02": "กุมภาพันธ์",
            "03": "มีนาคม",
            "04": "เมษายน",
            "05": "พฤษภาคม",
            "06": "มิถุนายน",
            "07": "กรกฎาคม",
            "08": "สิงหาคม",
            "09": "กันยายน",
            "10": "ตุลาคม",
            "11": "พฤศจิกายน",
            "12": "ธันวาคม"
        };
        let newdate = dateTime.split(" ");
        let date1 = newdate[0].split("-");
        let newDate = `${date1[2]} ${thmonth[date1[1]]} ${parseInt(date1[0]) + 543}`
        return newDate
    }

    function formateTime(dateTime) {
        let newdate = dateTime.split(" ");
        let time_1 = newdate[1].split(":");
        let timer = `${time_1[0]}:${time_1[1]}น.`;
        return `${timer}`;
    }
</script>

</html>