/* DATA TABLES */
var table;
function init_DataTables_danhsachcho() {
    table = $('#datatable-danhsachcho').DataTable({
        "ajax":
        {
            url: $("#ULocal").val() + 'goinguoinhabn/getDataCho/',
            type: 'POST',
        },
        error: function (response) {
            console.log(JSON.stringify(response));
        },
        "searching": false,
        "paging": true,
        "info": false,
        "destroy": true,
        "columnDefs": [
            {
                "targets": 0,
                "width": "5%",
                "className": "text-center",
                "sortable": true,
                "render": function (data, type, row, meta) {
                    return (meta.row + 1);
                }
            },
            {
                "targets": 1,
                "data": "maBN",
                "sortable": false,

                "width": '5%',
            },
            {
                "targets": 2,
                "data": "tenBN",
                "sortable": false,

                "width": '15%',

            },
            {
                "targets": 3,
                "width": '20%',
                "sortable": false,

                "data": "namSinh"
            },
            {
                "targets": 4,
                "width": '20%',
                "sortable": false,

                "data": "gioiTinh",

            },
            {
                "targets": 5,
                "width": '20%',
                "sortable": false,
                "data": "maTrangThai",
                "render": function (data, type, row) {
                    var $option = $("#trangthai option[value='" + data + "']");
                    var valueSelect = $option.text();
                    return '<input type="hidden" id="selectid" value="' + data + '">' + valueSelect;
                }
            },
            {
                "targets": 6,
                "width": '15%',
                "sortable": false,

                "data": "id",
                "render": function (data, type, row) {
                    var cho = "", id = "";
                    id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
                    cho = '<button class="cho btn btn-danger btn-sm" title="Chờ" data-toggle="tooltip"><i class="fa fa-hourglass-end"></i>&nbsp;Kết thúc</button>';
                    // huy = '<button class="huy btn btn-secondary btn-sm" title="Hủy" data-toggle="tooltip"><i class="fa fa-rotate-left"></i>&nbsp;Hủy bỏ</button>';
                    return [id, cho].join('');
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
    })
};
$(document).ready(function () {
    init_DataTables_danhsachcho();
    $("#datatable-danhsachcho_length").hide();
    $(document).on("click", ".cho", function () {
        Swal.fire({
            title: "Bạn có chắc chắn muốn kết thúc?",
            text: "Hành động này sẽ chuyển đổi tình trạng bệnh nhân từ đang cấp cứu sang đã khám!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Kết thúc!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                if (updateData($(this), $("#ULocal").val() + 'goinguoinhabn/doiTrangThaiDaKham/', 'Bênh nhân đã được cập nhật thành công.')) {
                    $('#datatable-danhsachcho').DataTable().ajax.reload();
                    $('#datatable-danhsachgoi').DataTable().ajax.reload();
                }
            }
        });
    });
    // $(document).on("click", ".huy", function () {
    //     Swal.fire({
    //         title: "Bạn có chắc chắn muốn hủy bỏ?",
    //         text: "Hành động này sẽ hủy gọi bệnh nhân và chuyển bệnh nhân về lại danh sách gọi!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Hủy bỏ!",
    //         cancelButtonText: "Quay lại"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             if (updateData($(this), $("#ULocal").val() + 'goinguoinhabn/doiTrangThaiChuaKham/', 'Bênh nhân đã được cập nhật thành công.')) {
    //                 $('#datatable-danhsachcho').DataTable().ajax.reload();
    //                 $('#datatable-danhsachgoi').DataTable().ajax.reload();
    //             }
    //         }
    //     });
    // });
});

