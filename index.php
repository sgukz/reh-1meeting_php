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
                    <input type="hidden" id="docno" value="<?= $_GET["docno"]?>">
                    <input type="hidden" id="userId" value="<?= $_GET["userId"]?>">
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
    </div>
</body>
<script src="src/assets/js/jquery-3.5.1.min.js"></script>
<script src="src/assets/js/materialize.min.js"></script>
<script src="src/assets/js/main.js"></script>
<script src="src/assets/js/sweetalert2.js"></script>
<script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script>
<script>
    let meeting_id = $("#docno").val();
    let userID = $("#userId").val();
    let base_url = "https://service-api-1meeting.herokuapp.com";
    let today = new Date().getTime();
    $("#btn_check_in").click(function() {
        saveCheckin(userID, meeting_id, 1);
    });

    $("#btn_check_out").click(function() {
        saveCheckin(userID, meeting_id, 2);
    });

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
                        window.location = `?docno=${data.data}&userId=${userId}`;
                    }, 1000)
                }
            })
            .fail((error) => {
                console.log(error);
            })
    }

    $.ajax({
            method: "GET",
            url: `${base_url}/getMeetingByDocno/${meeting_id}`,
            data: ""
        })
        .done((resp) => {
            // console.log(resp);
            if (resp.code === 200) {
                $("#loading").addClass("hidden");
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
                        url: `${base_url}/getMeetingRegisByUserID/${meeting_id}/${userID}`,
                        data: ""
                    })
                    .done((resp) => {
                        console.log(resp);
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
                $("#loading").removeClass("hidden");
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่พบข้อมูล...',
                    text: 'กรุณาลองใหม่อีกครั้ง',
                })
            }
        })


    liff.init({
            liffId: "1655384297-Y7egqg67",
        },
        () => {},
        (err) => alert(error.message)

    );

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