
function init_DataTables() {
    table = $('#datatable-bacsi').DataTable({
        "ajax": {
            url: $("#ULocal").val() + 'BacSi/getData/',
            type: 'POST',
        },
        error: function (response) {
            console.log(JSON.stringify(response));
        },
        dom: '<"dt-toolbar">frtlpi',
        destroy: true,
        searching: false,
        "columnDefs": [
            {
                "targets": 0,
                "width": '5%',
                "className": "text-center",
                "sortable": true,
                "render": function (data, type, row, meta) {
                    return (meta.row + 1);
                }
            },
            {
                "targets": 1,
                "width": '20%',
                "data": "TenBacSi"
            },
            {
                "targets": 2,
                "width": '10%',
                "data": "GioiTinh",
                "render": function (data, type, row) {
                    var valueSelect = $("#bacsi option[value='" + data + "']").text();
                    return '<input type="hidden" id="selectid" value="' + data + '">' + valueSelect;
                }
            },
            {
                "targets": 3,
                "width": '15%',
                "data": "soDienThoai"
            },
            {
                "targets": 4,
                "width": '15%',
                "data": "MaKhoaPhong",
                "render": function (data, type, row) {
                    var $option = $("#khoaphong option[value='" + data + "']");
                    var valueSelect = $option.text();
                    return '<input type="hidden" id="selectid" value="' + data + '">' + valueSelect;
                }
            },
            // {
            //     "targets": 5,
            //     "width": '25%',
            //     "data": "Avatar",
            //     "render": function (data, type, row) {
            //         if (isNewBacSi) {
            //             return renderAvatarForm();
            //         } else {
            //             return '<img src="' + data + '" alt="Avatar" class="avatar-img" style="width:50px;height:50px;">';
            //         }
            //     }
            // },
            {
                "targets": 5, "width": '5%', "data": "MaBacSi",
                "render": function (data, type, row) {
                    var save = "", update = "", del = "", id = "";
                    id = '<input type="hidden" name="id" id="id" value="' + data + '">';
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
            $("div.dt-toolbar").css({ display: "flex", justifyContent: "space-between", alignItems: "center" }).html(
                '<div class="left-toolbar">' +
                '<button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Thêm mới</button>' +
                '<button type="button" class="btn btn-info save"><i class="fa fa-floppy-o"></i> Lưu dữ liệu</button>' +
                '</div>' +
                '<div class="right-toolbar">' +
                '<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-floppy-o"></i></button>' +
                '<lable >&nbsp;Lưu dữ liệu khi thêm mới &nbsp;</lable>' +
                '<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-plus"></i></button>' +
                '<lable >&nbsp;Thêm mới bác sĩ &nbsp;</lable>'
                +
                '<button class="btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>' +
                '<lable >&nbsp;Lưu &nbsp;</lable>' +
                '<button class="btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>' +
                '<lable>&nbsp;Sửa &nbsp;</lable>' +
                '<button class="btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>' +
                '<lable>&nbsp;Xóa &nbsp;</lable>' +
                '</div>'
            );
            hiddenButton();
            $(".add-new").click(function () {
                isNewBacSi = true;
                addRowInput($('#datatable-bacsi'), 1);
            });
            $(".save").click(function () {
                Swal.fire({
                    title: "Bạn có muốn cập nhập không?",
                    text: "Hành động này sẽ lưu dữ liệu mới vào hệ thống",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Hủy",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Lưu"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (saveData($('#datatable-bacsi'), $("#ULocal").val() + 'bacsi/saveBacSi/', "'Bác sĩ đã được cập nhật thành công.'")) {
                            $('#datatable-bacsi').DataTable().ajax.reload(hiddenButton);
                        }
                    }
                });
            });
        }
    });
}
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(document).on("click", ".add", function () {
        Swal.fire({
            title: "Bạn có muốn cập nhập không?",
            text: "Hành động này sẽ lưu dữ liệu mới vào hệ thống",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Lưu"
        }).then((result) => {
            if (result.isConfirmed) {
                if (updateData($(this), $("#ULocal").val() + 'bacsi/saveBacSi/', 'Bác sĩ đã được cập nhật thành công.')) {
                    var editModeCells = $('td.td-input').length;
                    // console.log(editModeCells);
                    // console.log($(this).closest('tr').find('td').length - 2);
                    if (editModeCells <= $(this).closest('tr').find('td').length - 2) {
                        $('#datatable-bacsi').DataTable().ajax.reload(hiddenButton);
                    }
                }

            }
        });
    });

    $(document).on("click", ".edit", function () {
        addInput($('#datatable-bacsi'), $(this).closest('tr'));
    });

    $(document).on("click", ".delete", function () {
        Swal.fire({
            icon: "warning",
            title: "Bạn có chắc muốn không?",
            text: "Hành động này sẽ xóa đi bác sĩ trong hệ thống.",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonText: "Xóa",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33"
        }).then((result) => {
            if (result.isConfirmed) {
                if (deleteData(table, $(this), $("#ULocal").val() + 'bacsi/deleteBacSi/', 'Bác sĩ đã được xóa thành công.')) {
                    $('#datatable-bacsi').DataTable().ajax.reload(hiddenButton);
                }
            }
        })
    });
});
function hiddenButton() {
    if ($("#role-bacsi-saveBacSi").val() == "false") {
        $(".add-new").hide();
        $(".edit").hide();
        $(".add").hide();
        $(".save").hide();
    }
    if ($("#role-bacsi-deleteBacSi").val() == "false") {
        $(".delete").hide();
    }

}	