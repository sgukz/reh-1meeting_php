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
                        <strong class="blue-text"><b>Please Scan QR Code to sign for the meeting </b></strong>
                    </div>
                    <div id="section-show-data" class="hidden">
                        <input type="hidden" id="docno" value="<?= $_GET["docno"] ?>">
                        <div class="section hidden" id="section-data">
                            <div id="meeting_name" style="margin-bottom: 15px"></div>

                            <div id="meeting_room_name"></div>

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
                                <button type="button" id="btn_check_in" onclick="checkIn()" class="waves-effect waves-light btn"><b>Check-in</b></button>
                                <button type="button" id="btn_check_out" onclick="checkOut()" class="waves-effect waves-light btn red darken-3"><b>Check-Out</b></button>
                            </div>
                            <div class="center-align hidden" style="margin-top: 15px;" id="section_btn_cancel">
                                <button type="button" id="btn_cancel" onclick="cancelCheckin()" class="waves-effect waves-light btn red"><b>Cancel check-in</b></button>
                            </div>
                            <hr>
                            <div id="section_list_name"></div>
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
<script src="src/assets/js/DateTimeThai.js"></script>
<script src="src/assets/js/sweetalert2.js"></script>
<script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script>
<script>
    const formatAMPM = (date) => {
        let dateTime = new Date(date)
        let hours = dateTime.getHours();
        let minutes = dateTime.getMinutes();
        let ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        let strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    let meetingId = $("#docno").val();
    let base_url = "https://api.reh.go.th:9000";
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
                            let timerInterval
                            Swal.fire({
                                title: "Check-in",
                                text: "successfuly",
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
                                    window.location.reload();
                                }
                            })
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
                            let timerInterval
                            Swal.fire({
                                title: "Check-out",
                                text: "successfuly",
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
                                    window.location.reload();
                                }
                            })
                        }
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            });
    }

    function cancelCheckin() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                let is_check = 3;
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
                        // alert(JSON.stringify(data))
                        if (data.code === 200) {
                            let timerInterval
                            Swal.fire({
                                title: "Cancel checkin",
                                text: "successfuly",
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
                                    window.location.reload();
                                }
                            })
                        }
                    })
                    .fail((error) => {
                        alert(JSON.stringify(error))
                        console.log(error);
                    })
            })
    }

    function getProfileUser() {
        liff
            .getProfile()
            .then((profile) => {
                const userId = profile.userId;
                $.ajax({
                        method: "GET",
                        url: `${base_url}/checkUser/${userId}`
                    })
                    .done((resp) => {
                        let data = resp
                        if (data.code === 200) {
                            $("#loading").addClass("hidden");
                        } else if (data.code === 400) {
                            $("#loading").addClass("hidden");
                            let timerInterval
                            Swal.fire({
                                title: "You are not registered",
                                text: "waiting...",
                                icon: 'warning',
                                timer: 3000,
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
                                    window.location = "https://liff.line.me/1657432903-bGRepN3d?docno=" + meetingId;
                                }
                            })
                        }
                    })
                    .fail((error) => {
                        console.log(error);
                    })

            })
    }

    async function main() {
        await liff.init({
                liffId: "1657432903-V1Aolerg",
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
                            if (resp.code === 200) {
                                // console.log(resp);
                                $("#loading").addClass("hidden");
                                $("#section-lebel-scan").addClass("hidden");
                                $("#section-show-data").removeClass("hidden");
                                let data = resp.data[0]
                                let startDate = new Date(data.start_date).getTime();
                                let endDate = new Date(data.end_date).getTime();
                                // if ((startDate - today) / 1000 > 1800) {
                                //     $("#section_btn_check").addClass("hidden");
                                //     $("#is_check_in").html(`<span class='green-text'><b>สามารถเช็คอินเข้าห้องประชุมได้ก่อน 30 นาที</b></span>`);
                                // }
                                // if (today > endDate) {
                                //     $("#btn_check_in").addClass("hidden");
                                //     $("#btn_check_out").addClass("hidden");
                                //     $("#is_check_in").html(`<span class='red-text'><b>จบการประชุมแล้ว</b></span>`);
                                //     $("#is_check_out").html(`<span></span>`);
                                // }
                                $("#section-scan").addClass("hidden");
                                $("#lebel-scan").addClass("hidden");
                                $("#section-data").removeClass("hidden");
                                let stringDatestart = new Date(data.start_date).toDateString()
                                let stringDateEnd = new Date(data.end_date).toDateString()
                                let meeting_name = `<strong class='blue-text' style='font-weight: bold;font-size: 16px;'><b>Topic : ${data.meeting_name}</b></strong>`;
                                let meeting_room_name = `<strong><b>Meeting Room </b>${data.room_name}</strong>`
                                let meeting_date = `<strong><b>Meeting time</b> ${(stringDatestart === stringDateEnd ? stringDatestart : stringDatestart + " - " + stringDateEnd)}</strong>`;
                                let meeting_time = `<strong><b>Start the meeting</b> ${formatAMPM(data.start_date)} - ${formatAMPM(data.end_date)}</strong>`;
                                let meeting_total = `<strong><b>Signed ${resp.total[0].total_meeting}/${data.human_amount} person</b></strong>`;
                                $("#meeting_total").html(meeting_total);
                                $("#meeting_room_name").html(meeting_room_name);
                                $("#meeting_name").html(meeting_name);
                                $("#meeting_date").html(meeting_date);
                                $("#meeting_time").html(meeting_time);

                                $.ajax({
                                        method: "GET",
                                        url: `${base_url}/getMeetingRegisByUserID/${meeting_id}/${userId}`,
                                        data: ""
                                    })
                                    .done((resp) => {
                                        if (resp.data.length > 0) {
                                            $("#section_btn_cancel").removeClass("hidden")
                                            let dataRegis = resp.data[0]
                                            let stringCheckinDate = `${new Date(dataRegis.check_in_date).toDateString()}, ${formatAMPM(dataRegis.check_in_date)}`
                                            let stringCheckoutDate = `${new Date(dataRegis.check_out_date).toDateString()}, ${formatAMPM(dataRegis.check_out_date)}`
                                            let meeting_total = `<strong><b>Signed ${dataRegis.cntMeeting}/${data.human_amount} person</b></strong>`;
                                            $("#meeting_total").html(meeting_total);
                                            if (dataRegis.check_in_date !== null) {
                                                $("#btn_check_in").addClass("hidden");
                                                if (dataRegis.check_out_date !== null) {
                                                    $("#btn_check_out").addClass("hidden");
                                                    let is_check_out = `<span class="font-weight" style='font-weight: bold;' id="check_in_date">Check out time<br><span class='red-text'>${stringCheckoutDate}</span></span>`;
                                                    $("#is_check_out").html(is_check_out);
                                                }
                                                // $("#btn_check_out").removeClass("hidden");
                                                let is_check_in = `<span class="font-weight" id="check_in_date">Check in time<br><span class='green-text'>${stringCheckinDate}<span></span>`;
                                                $("#is_check_in").html(is_check_in);
                                            }
                                        } else {
                                            $("#section_btn_cancel").addClass("hidden")
                                        }
                                    })
                                $.ajax({
                                        method: "GET",
                                        url: `${base_url}/getCheckInMeeting/${meeting_id}`
                                    })
                                    .done((resp) => {
                                        console.log(resp);
                                        if (resp.data.length > 0) {

                                            let html = `<ul class="collection with-header">
                                                    <li class="collection-header blue darken-3">
                                                        <h6 class="white-text">List of registered users</h6>
                                                    </li>`
                                            resp.data.map(val => {
                                                let stringCheckinDate = `${new Date(val.check_in_date).toDateString()}, ${formatAMPM(val.check_in_date)}`
                                                html += `<li class="collection-item avatar">
                                                <span class="title">${val.fullname}</span>
                                                    <p>${val.depart_name} ${val.main_company}<br>
                                                        <span class='green-text'>Check in time :: ${stringCheckinDate}</span>
                                                    </p>
                                                    </li>`
                                                return true
                                            })
                                            html += `</ul>`
                                            $("#section_list_name").html(html);

                                        }
                                    })
                                    .fail((error) => {
                                        console.log(error);
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