var table;
function init_DataTables() {
    table = $('#datatable-trangthai').DataTable({
        "ajax":
        {
            url: $("#ULocal").val() + 'trangthai/getData/',
            type: 'POST'
        },
        error: function (response) {
            alert(JSON.stringify(response))
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
                "width": '85%',
                "data": "tenTrangThai"
            },
            {
                "targets": 2,
                "width": '10%',
                "data": "maTrangThai",
                "render": function (data, type, row) {
                    var save = "", update = "", del = "", id = "";
                    id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
                    save = '<button id="btn-update" class="add btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>';
                    update = '<button class="edit btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>';
                    if (!(data == 1 || data == 2 || data == 3)) {
                        del = '<button class="delete btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>';
                    }
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
                '<lable >&nbsp;Thêm mới trạng thái &nbsp;</lable>' +
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
                addRowInput($('#datatable-trangthai'), 1);
            });

            $(".save").click(function () {

                Swal.fire({
                    title: "Bạn có chắc chắn muốn lưu?",
                    text: "Hành động này sẽ thêm mới một trạng thái!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Lưu!",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (saveData($('#datatable-trangthai'), $("#ULocal").val() + 'trangthai/saveTrangThai/', "'Trạng thái đã được cập nhật thành công.'")) {
                            $('#datatable-trangthai').DataTable().ajax.reload(hiddenButton);
                        }
                    }

                });

            });
        }

    });
};


$(document).ready(function () {


    $("#datatable-trangthai_filter").css({
        "display": "inline-block",
        "float": "right"
    });
    $('[data-toggle="tooltip"]').tooltip();
    // update data
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
                if (updateData($(this), $("#ULocal").val() + 'trangthai/saveTrangThai/', 'Trạng thái đã được cập nhật thành công.')) {
                    var editModeCells = $('td.td-input').length;
                    // console.log(editModeCells);
                    // console.log($(this).closest('tr').find('td').length - 2);
                    if (editModeCells <= $(this).closest('tr').find('td').length - 2) {
                        $('#datatable-trangthai').DataTable().ajax.reload(hiddenButton);
                    }
                }
            }
        });
    });

    // Edit row on edit button click
    $(document).on("click", ".edit", function () {
        addInput($('#datatable-trangthai'), $(this).closest('tr'));
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
                if (deleteData(table, $(this), $("#ULocal").val() + 'trangthai/deleteTrangThai/', 'Trạng thái đã được xóa thành công.')) {
                    $('#datatable-trangthai').DataTable().ajax.reload(hiddenButton);

                }
            }
        });
    });

});
function hiddenButton() {

    if ($("#role-trangthai-saveTrangThai").val() == "false") {
        $(".add-new").hide();
        $(".edit").hide();
        $(".add").hide();
        $(".save").hide();
    }
    if ($("#role-trangthai-deleteTrangThai").val() == "false") {
        $(".delete").hide();
    }

}	