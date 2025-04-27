/* DATA TABLES */
var table;
function init_DataTables() {
    table = $('#datatable-benhnhan').DataTable({
        "ajax":
        {
            url: $("#ULocal").val() + 'benhnhan/getData/',
            type: 'POST'
        },
        error: function (response) {
            alert(JSON.stringify(response))
        },
        dom: '<"dt-toolbar">frtlpi',
        destroy: true,

        "searching": true,
        "columnDefs": [
            {
                "targets": 0,
                "width": '5%',
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    return (meta.row + 1);
                }
            },
            {
                "targets": 1,
                "width": '10%',
                "className": "text-center",
                "data": "maBN"
            },
            {
                "targets": 2,
                "width": '15%',
                "data": "tenBN",
                "render": function (data, type, row) {
                    if (type === 'display' && data) {
                        var words = data.split(' ');
                        var result = [];
                        for (var i = 0; i < words.length; i += 3) {
                            result.push(words.slice(i, i + 3).join(' '));
                        }
                        return result.join(' <br>');
                    }
                    return data;
                }
            },
            {
                "targets": 3,
                "width": '5%',
                "className": "text-center",
                "data": "namSinh"
            },
            {
                "targets": 4,
                "width": '5%',
                "className": "text-center",
                "data": "gioiTinh",
                "render": function (data, type, row) {
                    var valueSelect = $("#gioitinh option[value='" + data + "']").text();
                    return '<input type="hidden" id = "selectid" value="' + data + '">' + valueSelect;
                }
            },

            {
                "targets": 5,
                "width": '10%',
                "data": "chuanDoan",
                "render": function (data, type, row) {
                    if (type === 'display' && data) {
                        var words = data.split(' ');
                        var result = [];
                        for (var i = 0; i < words.length; i += 3) {
                            result.push(words.slice(i, i + 3).join(' '));
                        }
                        return result.join(' <br>');
                    }
                    return data;
                }
            },
            {
                "targets": 6,
                "width": '15%',
                "data": "bacSi",
                "render": function (data, type, row) {
                    if (type === 'display' && data) {
                        var words = data.split(' ');
                        var result = [];
                        for (var i = 0; i < words.length; i += 3) {
                            result.push(words.slice(i, i + 3).join(' '));
                        }
                        return result.join(' <br>');
                    }
                    return data;
                }
            },
            {
                "targets": 7,
                "width": '15%',
                "data": "maTrangThai",
                "render": function (data, type, row) {
                    var $option = $("#trangthai option[value='" + data + "']");
                    var valueSelect = $option.text();
                    if (valueSelect === "Đang gọi") {
                        return '<input type="hidden" id="selectid" value="' + data + '">' + '<span style="color:blue;font-weight: bold;font-size:16px;">' + valueSelect + '</span>';
                    } else {
                        var words = valueSelect.split(' ');
                        var result = [];
                        for (var i = 0; i < words.length; i += 3) {
                            result.push(words.slice(i, i + 3).join(' '));
                        }
                        return '<input type="hidden" id="selectid" value="' + data + '">' + '<span style="color:#dc3545;font-weight: bold;font-size:16px;">' + result.join(' <br>') + '</span>';
                    }
                }
            },
            {
                "targets": 8,
                "width": '10%',
                "render": function (data, type, row) {
                    var call = "", end = "";
                    call = '<button class="call btn btn-warning btn-sm" title="Gọi" data-toggle="tooltip"><i class="fa fa-bell"></i>&nbsp;Gọi</button>';
                    end = '<button class="end btn btn-danger btn-sm" title="Kết thúc" data-toggle="tooltip"><i class="fa fa-hourglass-end"></i>&nbsp;Kết thúc</button>';
                    return [call, end].join('');
                }
            },
            {
                "targets": 9,
                "width": '10%',
                "data": "id",
                "render": function (data, type, row) {
                    var save = "", update = "", del = "", id = "";
                    id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
                    save = '<button id="btn-update" class="add btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>';
                    update = '<button class="edit btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>';
                    del = '<button class="delete btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>';
                    return [id, save, update, del].join('');
                }
            }

        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ dòng trên một trang",
            "zeroRecords": "Xin lỗi không tìm thấy dữ liệu",
            "info": "Hiển thị trang _PAGE_ of _PAGES_ trang",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Sau",
                "previous": "Trước"
            }
        },
        initComplete: function () {
            $("div.dt-toolbar").css({
                display: "flex",
                justifyContent: "space-between",
                alignItems: "center",
            }).html(
                '<div class="left-toolbar">' +
                '<button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Thêm mới</button>' +
                '<button type="button" class="btn btn-info save"><i class="fa fa-floppy-o"></i> Lưu dữ liệu</button>' +
                '</div>' +
                '<div class="right-toolbar">' +
                '<div>' +
                '<span style="color:#dc3545;font-weight: bold;font-size:16px;">Trạng thái khác &nbsp </span>' +
                '<span style="color: blue;font-weight: bold;font-size:16px;">Đang gọi &nbsp </span>' +

                '<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-floppy-o"></i></button>' +
                '<lable >&nbsp;Lưu dữ liệu khi thêm mới &nbsp;</lable>' +
                '<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-plus"></i></button>' +
                '<lable >&nbsp;Thêm mới bệnh nhân &nbsp;</lable>'
                + '</div>' + '<div>' +
                '<button class="btn btn-warning btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-bell"></i></button>' +
                '<lable >&nbsp;Gọi người nhà &nbsp;</lable>' +
                '<button class="btn btn-danger btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hourglass-end"></i></button>' +
                '<lable >&nbsp;Kết thục gọi &nbsp;</lable>' +
                '<button class="btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>' +
                '<lable >&nbsp;Lưu &nbsp;</lable>' +
                '<button class="btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>' +
                '<lable>&nbsp;Sửa &nbsp;</lable>' +
                '<button class="btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>' +
                '<lable>&nbsp;Xóa &nbsp;</lable>' +
                '</div>'
                +
                '</div>'
            );
            hiddenButton();
            $(".add-new").click(function () {
                addRowInput($('#datatable-benhnhan'), 1);

            });
            $(".save").click(function () {
                Swal.fire({
                    title: "Bạn có chắc chắn muốn lưu?",
                    text: "Hành động này sẽ thêm một bệnh nhân mới!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Lưu!",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (saveData($('#datatable-benhnhan'), $("#ULocal").val() + 'benhnhan/saveBenhNhan/', "'Người dùng đã được cập nhật thành công.'")) {
                            $('#datatable-benhnhan').DataTable().ajax.reload(hiddenButton);
                        }
                    }

                });
            });
        }

    });
};

$(document).ready(function () {

    // $('[data-toggle="tooltip"]').tooltip();

    $(document).on("click", ".end", function () {
        Swal.fire({
            title: "Bạn có chắc chắn muốn kết thúc?",
            text: "Hành động này sẽ dừng gọi bệnh nhân và chuyển trạng thái hoàn thành!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Kết thúc!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                if (updateData($(this), $("#ULocal").val() + 'goinguoinhabn/doiTrangThaiDaKham/', 'Bênh nhân đã được cập nhật thành công.')) {
                    $('#datatable-benhnhan').DataTable().ajax.reload(hiddenButton);
                }
            }
        });
    });
    $(document).on("click", ".call", async function () {
        let receptionDeskOptions = {};

        await $.ajax({
            url: $("#ULocal").val() + 'quaytiepnhan/getData/',
            type: 'POST',
            dataType: "json",
            success: function (response) {
                response.data.forEach(desk => {
                    receptionDeskOptions[desk.maQuay] = desk.tenQuayTiepNhan;
                });
            },
            error: function () {
                Swal.fire("Lỗi", "Không thể lấy dữ liệu quầy tiếp nhận", "error");
            }
        });

        if (Object.keys(receptionDeskOptions).length === 0) {
            return;
        }

        let radioButtonsHtml = '<div class="swal2-radio-list">';
        const daoNguocDanhSach = Object.entries(receptionDeskOptions).reverse();
        for (const [key, value] of daoNguocDanhSach) {
            radioButtonsHtml += `
                <label>
                    <input type="radio" name="receptionDesk" value="${key}"> ${value}
                </label>
            `;
        }
        radioButtonsHtml += '</div>';

        const { value: selectedDesk } = await Swal.fire({
            title: "Vui lòng chọn quầy tiếp nhận",
            html: radioButtonsHtml,
            showCancelButton: true,
            preConfirm: () => {
                const selectedValue = document.querySelector('input[name="receptionDesk"]:checked');
                if (selectedValue) {
                    return selectedValue.value;
                } else {
                    Swal.showValidationMessage("Vui lòng chọn quầy!");
                    return false;
                }
            }
        });
        if (selectedDesk) {
            if (updateData($(this), $("#ULocal").val() + 'goinguoinhabn/doiTrangThaiChoKham/', receptionDeskOptions[selectedDesk])) {
                $('#datatable-benhnhan').DataTable().ajax.reload(hiddenButton);
            }
        }
    });

    $(document).on("click", ".add", function () {
        Swal.fire({
            title: "Bạn có chắc chắn muốn lưu?",
            text: "Hành động này sẽ thay đổi dữ liệu cũ!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Lưu!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                if (updateData($(this), $("#ULocal").val() + 'benhnhan/saveBenhNhan/', 'Bênh nhân đã được cập nhật thành công.')) {
                    var editModeCells = $('td.td-input').length;
                    // console.log(editModeCells);
                    // console.log($(this).closest('tr').find('td').length - 3);

                    if (editModeCells <= $(this).closest('tr').find('td').length - 3) {
                        $('#datatable-benhnhan').DataTable().ajax.reload(hiddenButton);
                    }

                }
            }
        });
    });

    // Edit row on edit button click
    $(document).on("click", ".edit", function () {
        addInput($('#datatable-benhnhan'), $(this).closest('tr'));
    });

    // Delete row on delete button click
    $(document).on("click", ".delete", function () {
        Swal.fire({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Hành động này không thể hoàn tác. Bạn sẽ không thể khôi phục lại dữ liệu sau khi xóa!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                if (deleteData(table, $(this), $("#ULocal").val() + 'benhnhan/deleteBenhNhan/', 'Ngươi dùng đã được xóa thành công.')) {
                    $('#datatable-benhnhan').DataTable().ajax.reload(hiddenButton);
                }
            }
        });
    });

    $("#mabenhnhan").on("keyup", function (e) {
        table.column(1).search(this.value).draw();
    });
    $("#tenbenhnhan").on("keyup", function (e) {
        table.column(2).search(this.value).draw();

    });
    $("#bacsikham").on("keyup", function (e) {
        table.column(6).search(this.value).draw();

    });
    $("#loctrangthai").on("change", function (e) {
        table.column(7).search(this.value).draw();

    });
    $("#datatable-benhnhan_filter").css({ display: 'none' });

});
function hiddenButton() {

    if ($("#role-benhnhan-saveBenhNhan").val() == "false") {
        $(".add-new").hide();
        $(".edit").hide();
        $(".add").hide();
        $(".save").hide();
    }
    if ($("#role-benhnhan-deleteBenhNhan").val() == "false") {
        $(".delete").hide();
    }

}	