<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REH 1Meeting</title>
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
                    <div class="center-align" id="section-lebel-scan">
                        <strong class="blue-text"><b>กรุณา Scan QR Code เพื่อเข้าร่วมประชุม</b></strong>
                    </div>
                    <div id="section-show-data" class="hidden">
                        <input type="hidden" id="docno" value="<?= $_GET["docno"] ?>">
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

                            <div id="is_check_out" class="center-align"></div>
                            <!-- <span class="grey lighten-3 green-text" id="check_in_date">เข้าร่วมประชุมเมื่อ<br> วันที่ 17
                        ธันวาคม 2563 เวลา 16.59น.</span> -->
                            <br>
                            <div class="center-align" id="section_btn_check">
                                <button type="button" id="btn_check_in" onclick="checkIn()" class="waves-effect waves-light btn green accent-4"><b>Check-in</b></button>
                                <button type="button" id="btn_check_out" onclick="checkOut()" class="waves-effect waves-light btn red darken-3"><b>Check-Out</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-scan">
            <div class="col s12 center-align">
                <a class="waves-effect waves-light btn-large pink accent-3 pulse" onclick="window.location='https://line.me/R/nv/QRCodeReader'">
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
    let meetingId = $("#docno").val();
    let base_url = "https://service-api-1meeting.herokuapp.com";
    let today = new Date().getTime();

    function checkIn() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                let is_check = 1;
                let docno = meetingId;
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
                                window.location.reload();
                            }, 1000)
                        }
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            });
    }

    function checkOut() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                let is_check = 2;
                let docno = meetingId;
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
                                window.location.reload();
                            }, 1000)
                        }
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            });
    }

    function getProfileUser() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                $.ajax({
                        method: "GET",
                        url: `${base_url}/checkUser/${userId}`,
                        data: ""
                    })
                    .done((resp) => {
                        let data = resp
                        if (data.code === 200) {
                            $("#loading").addClass("hidden");
                        } else if (data.code === 400) {
                            $("#loading").addClass("hidden");
                            setTimeout(() => {
                                Swal.fire({
                                    'icon': "error",
                                    'title': "คุณยังไม่ลงทะเบียน",
                                    'text': "กรุณารอสักครู่...",
                                    'showConfirmButton': false,
                                })
                                window.location = "https://liff.line.me/1655384297-Y7egqg67";
                            }, 1000);
                        }
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            })
    }
    async function main() {
        await liff.init({
                liffId: "1655384297-9KVyzyQd",
            },
            () => {
                getProfileUser();
            }, (err) => alert(err.message)
        );
        const queryString = decodeURIComponent(window.location.search);
        const params = new URLSearchParams(queryString);
        if (params.get("docno") !== null) {
            let meeting_id = params.get("docno");
            liff
                .getProfile()
                .then((profile) => {
                    const userId = profile.userId;
                    $.ajax({
                            method: "GET",
                            url: `${base_url}/getMeetingByDocno/${meeting_id}`,
                            data: ""
                        })
                        .done((resp) => {
                            // console.log(resp);
                            if (resp.code === 200) {
                                $("#loading").addClass("hidden");
                                $("#section-lebel-scan").addClass("hidden");
                                $("#section-show-data").removeClass("hidden");
                                let data = resp.data[0]
                                let startDate = new Date(data.start_date).getTime();
                                let endDate = new Date(data.end_date).getTime();
                                if ((startDate - today) / 1000 > 1800) {
                                    $("#section_btn_check").addClass("hidden");
                                    $("#is_check_in").html(`<span class='green-text'><b>สามารถเช็คอินเข้าห้องประชุมได้ก่อน 30 นาที</b></span>`);
                                }
                                if (today > endDate) {
                                    $("#btn_check_in").addClass("hidden");
                                    $("#btn_check_out").addClass("hidden");
                                    $("#is_check_in").html(`<span class='red-text'><b>จบการประชุมแล้ว</b></span>`);
                                    $("#is_check_out").html(`<span></span>`);
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
                                        url: `${base_url}/getMeetingRegisByUserID/${meeting_id}/${userId}`,
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
                                                    let is_check_out = `<span class="grey lighten-3 red-text" id="check_in_date">ออกประชุมเมื่อ<br> 
                                    วันที่ ${formateDate(dataRegis.check_out_date)} เวลา ${formateTime(dataRegis.check_out_date)}</span>`;
                                                    $("#is_check_out").html(is_check_out);
                                                }
                                                // $("#btn_check_out").removeClass("hidden");
                                                let is_check_in = `<span class="grey lighten-3 green-text" id="check_in_date">เข้าร่วมประชุมเมื่อ<br> 
                                    วันที่ ${formateDate(dataRegis.check_in_date)} เวลา ${formateTime(dataRegis.check_in_date)}</span>`;
                                                $("#is_check_in").html(is_check_in);
                                            }
                                        }
                                    })
                            } else {
                                $("#loading").removeClass("hidden");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่พบข้อมูล...',
                                    text: 'กรุณาลองใหม่อีกครั้ง',
                                })
                            }
                        })
                });
        }
    }
    main();
</script>

</html>