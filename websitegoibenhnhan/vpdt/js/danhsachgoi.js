/* DATA TABLES */
var table;
function init_DataTables_danhsachgoi() {
    table = $('#datatable-danhsachgoi').DataTable({
        "ajax":
        {
            url: $("#ULocal").val() + 'goinguoinhabn/getDataGoi/',
            type: 'POST',
        },
        error: function (response) {
            console.log(JSON.stringify(response));
        },
        "searching": false,
        "destroy": true,
        "info": false,
        "paging": true,
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
                "width": '15%',
                "sortable": false,

                "data": "tenBN"
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
                    var goi = "", id = "";
                    id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
                    goi = '<button class="goi btn btn-warning btn-sm" title="Gọi" data-toggle="tooltip"><i class="fa fa-bell"></i>&nbsp; Gọi</button>';
                    return [id, goi].join('');
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

    });
};
$(document).ready(function () {
    init_DataTables_danhsachgoi();
    $("#datatable-danhsachgoi_length").hide();
    $(document).on("click", ".goi", function () {
        Swal.fire({
            title: "Bạn có chắc chắn muốn gọi người nhà bệnh nhân này không?",
            text: "Hành động này sẽ chuyển đổi trại thái người bệnh từ đang chờ sang đang cấp cứu",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Gọi!",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                if (updateData($(this), $("#ULocal").val() + 'goinguoinhabn/doiTrangThaiChoKham/', 'Bênh nhân đã được cập nhật thành công.')) {
                    $('#datatable-danhsachcho').DataTable().ajax.reload();
                    $('#datatable-danhsachgoi').DataTable().ajax.reload();
                }
            }
        });

    });
});


