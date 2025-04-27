$(document).ready(function () {

    var scrollSpeed = 20;
    var scrollInterval;

    function CDdanhsach() {
        var $chieudaiDanhsach = $('#patient-list-2');
        var chieudai = 0;
        $chieudaiDanhsach.find('.speech-bubble').each(function () {
            chieudai += 15.601;
        });
        $chieudaiDanhsach.css('height', chieudai + 'vh');
    }

    var logo = $("#ULocal").val() + 'images/logo.png';
    $("#phongbenhPlaceholder").html(
        "<div style='display: flex; align-items: center; justify-content: center;'>" +
        "<img src='" + logo + "' style='width: 7.5vw; margin-right: 1vw;'>" +
        "<div style='display: inline-block; text-align: center;'>" +
        "<h2 style='font-size: 3.5vw; margin: 0; text-shadow: 2.1px 2.1px 0 hsl(200deg 12.59% 77.58%);'>KHOA</h2>" +
        "<h2 style='font-size: 3.5vw; margin: 0;text-shadow: 2.1px 2.1px 0 hsl(200deg 12.59% 77.58%);'>CẤP CỨU</h2>" +
        "</div>" +
        "</div>" +
        "<h2 style='margin: 0.5vw 0 0.1vw 0; font-size: 1.5vw;'>NHANH CHÓNG - KỊP THỜI - CHÍNH XÁC</h2>" +
        "<h2 style='margin: 0.1vw 0; font-size: 2vw;'>Quickly - Timely - Exactly</h2>"
    );
    var ngayGoiMN = null;
    function loadTrangThai() {
        return $.ajax({
            url: $("#ULocal").val() + 'trangthai/getData/',
            type: 'GET',
            dataType: "json",
            success: function (response) {
                danhSachTT = response.data;
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi lấy dữ liệu trạng thái:", status, error);
            }
        });
    }
    function loadtrangbn() {
        $.when(
            $.ajax({
                url: $("#ULocal").val() + 'goinguoinhabn/getDataCho/',
                type: 'POST',
                dataType: "json"
            }),
            $.ajax({
                url: $("#ULocal").val() + 'goinguoinhabn/getDataGoi/',
                type: 'POST',
                dataType: "json"
            }),
            loadTrangThai()
        ).then(function (dataCho, dataGoi) {
            var dataCho = dataCho[0].data;
            var dataGoi = dataGoi[0].data;
            if (dataCho.length > 0) {
                var LastBNName = dataCho[dataCho.length - 1].tenBN;
                var ngayGoiMoiNhat = dataCho[dataCho.length - 1].ngayGoiMoiNhat;
                var quayTiepNhan = dataCho[dataCho.length - 1].quayTiepNhan;
                if (ngayGoiMoiNhat > ngayGoiMN) {
                    var notificationSound = document.getElementById('notificationSound');
                    notificationSound.play().then(() => {
                        notificationSound.muted = false;
                        notificationSound.play().catch(error => {
                            console.log('Autoplay was prevented:', error);
                        });
                    }).catch(error => {
                        console.log('Autoplay was prevented:', error);
                    });

                }
                if (ngayGoiMoiNhat >= ngayGoiMN || ngayGoiMN === null) {
                    ngayGoiMN = ngayGoiMoiNhat;
                    $("#thongbaoBN").html(
                        "<div style='font-size: 1.8vw;'>Xin mời người nhà bệnh nhân:</div>" +
                        "<div style='text-align: center;'><h1><b style='color: red; font-size: 3vw; text-shadow: 2.1px 2.1px 0 hsl(200deg 12.59% 77.58%);'>" + LastBNName + "</b></h1></div>"
                    );
                    if (quayTiepNhan !== "") {

                        $("#bacsiPlaceholder").html("<b style='text-align:center; font-size: 2.5vw;'>Vui lòng gặp ở " + quayTiepNhan + "</b>");
                    }
                }
                else {
                    $("#thongbaoBN").html("<b style='font-size: 2.5vw;'>Xin vui lòng chờ</b>");
                    $("#bacsiPlaceholder").html("");
                }

            } else {
                $("#thongbaoBN").html("<b style='font-size: 2.5vw;'>Xin vui lòng chờ</b>");
                $("#bacsiPlaceholder").html("");
                ngayGoiMN = null;
            }
            DanhsachChoGoi(dataCho, dataGoi);
        });
    }

    function DanhsachChoGoi(dataCho, dataGoi) {

        $("#patient-list-1").empty();
        $("#patient-list-2").empty();

        var allPatients = dataCho.concat(dataGoi);

        $.each(allPatients, function (index, value) {
            var statusClass = dataCho.includes(value) ? 'goi' : 'trang-thai-khac';
            var statusText = dataCho.includes(value) ? 'Gọi' : value.maTrangThai;

            var patientNameClass = (value.tenBN.length + value.namSinh.length) > 19 ? 'scrolling-name' : '';
            var doctorInfo = value.bacSi ? " Bác sĩ " + value.bacSi : "";
            var chuanDoan = value.chuanDoan ? " Chẩn đoán " + value.chuanDoan : "";
            var namSinh = value.namSinh == 0 ? "" : "<span class='short-vertical-line'></span>" + value.namSinh;
            var gioiTinh = value.gioiTinh === "Nam" ? '<i style="color:blue" class="fa fa-mars"></i>' : '<i style="color:#f50976" class="fa fa-venus"></i>';
            var detailsText1 = doctorInfo;
            var detailsText2 = chuanDoan;
            var detailsHTML1 = detailsText1.length > 40 ? "<div class='scroll-container'><div class='scrolling-name'>" + detailsText1 + "</div></div>"
                : "<div class=''>" + detailsText1 + "</div>";

            // "<div class=''>" + detailsText1 + "</div>";
            var detailsHTML2 = detailsText2.length > 40 ? "<div class='scroll-container'><div class='scrolling-name'>" + detailsText2 + "</div></div>"
                : "<div class=''>" + detailsText2 + "</div>";
            // var detailsHTML = detailsText.length > 80
            //     ? "<div class='scroll-container'><div class='scrolling-name'>" + detailsText + "</div></div>"
            //     : "<div class=''>" + detailsText + "</div>";
            var matchingStatus = danhSachTT.find(item => item.maTrangThai === statusText);
            if (matchingStatus) {
                statusText = matchingStatus.tenTrangThai;
            }
            var fontSizeClass = statusText.length > 15 ? 'small-font-size' : '';

            var patientHTML =
                "<div class='speech-bubble'>" +

                "<div class='left-frame'>" +
                "<div><b class='patient-id'>" + (index + 1) + "</b></div>" +
                "</div>" +

                "<div class='patient-info'>" +

                "<div class='patient-name-container'>" +
                detailsHTML1 +
                "<div class='scroll-container'>" +
                // "<span class='nam-sinh-font-size '>" + namSinh + "</span>" +
                "<b class='patient-details " + patientNameClass + "'>" + value.tenBN + namSinh + "</b>" +
                "</div>" + detailsHTML2 +
                "</div>" +

                "<div class='patient-status-container'>" +
                "<div class='patient-status " + statusClass + "  " + fontSizeClass + "'>" + statusText + "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

            if (index < 4) {
                $("#patient-list-1").append(patientHTML);
            } else {
                $("#patient-list-2").append(patientHTML);
            }
        });
        CDdanhsach();
        startAutoScroll();

    }

    function startAutoScroll() {
        var $scrollBody = $('#patient-list-2-container');
        var scrollStep = 1;
        var originalContentHeight = $('#patient-list-2').prop('scrollHeight');

        if ($('#patient-list-2 .speech-bubble').length >= 5) {
            $('#patient-list-2-clone').remove();
            $scrollBody.data('cloned', false);

            if (!$scrollBody.data('cloned')) {
                var $clone = $('#patient-list-2').clone().attr('id', 'patient-list-2-clone');
                $scrollBody.append($clone);
                $scrollBody.data('cloned', true);
            }

            clearInterval(scrollInterval);

            scrollInterval = setInterval(function () {
                var currentScroll = $scrollBody.scrollTop();
                var newScroll = currentScroll + scrollStep;
                if (newScroll >= originalContentHeight) {
                    $scrollBody.scrollTop(0);
                } else {
                    $scrollBody.scrollTop(newScroll);
                }
            }, scrollSpeed);
        } else {
            clearInterval(scrollInterval);
            $scrollBody.scrollTop(0);
            $('#patient-list-2-clone').remove();
            $scrollBody.data('cloned', false);
        }
    }

    loadtrangbn();
    setInterval(function () {
        loadtrangbn();
    }, 10000);
});
