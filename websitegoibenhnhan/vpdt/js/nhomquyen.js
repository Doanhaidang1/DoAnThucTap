/* DATA TABLES */
var table;
function init_DataTables() {
	table = $('#datatable-nhomquyen').DataTable({
		"ajax":
		{
			url: $("#ULocal").val() + 'nhomquyen/getData/',
			type: 'POST',
			data: function (d) {
				return $.extend({}, d, {
					"tenNQ": $("#tenNQ").val()
				});
			},
			error: function (response) {
				alert(JSON.stringify(response))
			},
		},
		"pageLength": $('#pageLength').val(),
		"searching": false,
		"order": [[0, "desc"]],
		//scrollY:        '50vh',
		scrollCollapse: true,
		dom: '<"dt-toolbar">frtlpi',
		responsive: true,
		bAutoWidth: false,
		destroy: true,
		"columnDefs": [
			{
				"targets": 0,
				"width": '5%',
				"className": "text-center",
				"sortable": true,
				"render": function (data, type, row, meta) {
					return (meta.row + 1);//[row].join('');
				}
			},
			{
				"targets": 1,
				"width": '50%',
				"data": "tenNQ"

			},
			{
				"targets": 2,
				"width": '5%',
				"data": "maNQ",
				"sortable": false,
				"render": function (data, type, row) {
					var save = "", update = "", del = "", id = "", policy = "";
					id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
					save = '<button id="btn-update" class="add btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>';
					update = '<button class="edit btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>';
					if (data != 5 && data != 51 && data != 52) {
						del = '<button class="delete btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>';
					}
					policy = '<button class="policy btn btn-primary btn-sm" title="Phân quyền" data-toggle="tooltip"><i class="glyphicon glyphicon-user"></i></button>';
					return [id, save, policy, update, del].join('');
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
				'<div>' +
				'<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-floppy-o"></i></button>' +
				'<lable >&nbsp;Lưu dữ liệu khi thêm mới &nbsp;</lable>' +
				'<button class="btn btn-info btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-plus"></i></button>' +
				'<lable >&nbsp;Thêm mới nhóm quyền &nbsp;</lable>'
				+ '</div>' + '<div>' +
				'<button class="btn btn-primary btn-sm" title="Lưu" data-toggle="tooltip"><i class="fa fa-hdd-o"></i></button>' +
				'<lable >&nbsp;Lưu &nbsp;</lable>' +
				'<button class="btn btn-primary btn-sm" title="Phân quyền" data-toggle="tooltip"><i class="glyphicon glyphicon-user"></i></button>' +
				'<lable >&nbsp;Phân quyền &nbsp;</lable>' +
				'<button class="btn btn-warning btn-sm" title="Sửa" data-toggle="tooltip"><i class="glyphicon glyphicon-cog"></i></button>' +
				'<lable>&nbsp;Sửa &nbsp;</lable>' +
				'<button class="btn btn-danger btn-sm" title="Xóa" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>' +
				'<lable>&nbsp;Xóa &nbsp;</lable>' +
				'</div>'
				+
				'</div>'
			);
			hiddenButton();
			// Append table with add row form on add new button click
			$(".add-new").click(function () {
				addRowInput($('#datatable-nhomquyen'), 1);
			});

			// save new row
			$(".save").click(function () {

				Swal.fire({
					title: "Bạn có chắc chắn muốn lưu?",
					text: "Hành động này sẽ thêm mới một nhóm quyền!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Lưu!",
					cancelButtonText: "Hủy"
				}).then((result) => {
					if (result.isConfirmed) {

						if (saveData($('#datatable-nhomquyen'), $("#ULocal").val() + 'nhomquyen/save/', "'Nhóm quyền đã được cập nhật thành công.'")) {
							$('#datatable-nhomquyen').DataTable().ajax.reload(hiddenButton);
						}
					}
				});

			});
		}
	});
};

$(document).ready(function () {

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
				if (updateData($(this), $("#ULocal").val() + 'nhomquyen/save/', 'Nhóm quyền đã được cập nhật thành công.')) {
					var editModeCells = $('td.td-input').length;
					// console.log(editModeCells);
					// console.log($(this).closest('tr').find('td').length - 2);
					if (editModeCells <= $(this).closest('tr').find('td').length - 2) {
						$('#datatable-nhomquyen').DataTable().ajax.reload(hiddenButton);
					}

				}
			}
		});
	});

	// Edit row on edit button click
	$(document).on("click", ".edit", function () {
		addInput($('#datatable-nhomquyen'), $(this).closest('tr'));
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
				if (deleteData(table, $(this), $("#ULocal").val() + 'nhomquyen/delete/', 'Nhóm quyền đã được xóa thành công.')) {
					$('#datatable-nhomquyen').DataTable().ajax.reload(hiddenButton);

				}
			}
		});
	});

	$(document).on("click", ".policy", function () {
		var tr = $(this).closest('tr');
		var row = table.row(tr);

		$("#modal-phanquyen").modal({
			backdrop: "static"
		});

		$("#modal-phanquyen .modal-title").html("Phân quyền nhóm: " + row.data().tenNQ);

		var maNQ = getId($(this));

		url = $("#ULocal").val() + 'nhomquyen/phanquyen/';
		// Save data
		$.ajax({
			url: url,
			data: {
				'maNQ': maNQ
			},
			type: 'POST',
			dataType: "text",
			cache: false,
			//async: false,
			error: function (htmlText) {
				alert("loi :" + JSON.stringify(htmlText));
			},
			success: function (htmlText) {
				$("#modal-phanquyen .modal-body").html(htmlText);
				$("#username").val(row.data().maNQ);
			}
		});
	});

	$(document).on("click", ".save-hang-modal", function () {
		Swal.fire({
			title: "Bạn có chắc chắn cập nhập quyền?",
			text: "Hành động này làm thay đổi quyền hiện tại của bạn!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Lưu!",
			cancelButtonText: "Hủy"
		}).then((result) => {
			if (result.isConfirmed) {
				url = $("#ULocal").val() + 'nhomquyen/savePhanquyen/';
				$.ajax({
					type: 'post',
					url: url,
					data: $('#frmQuyen').serialize(),
					dataType: "JSON",
					cache: false,
					error: function (json) {
						alert("loi :" + JSON.stringify(json));
					},
					success: function (json) {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							}
						});
						Toast.fire({
							icon: "success",
							title: "Bạn đã lưu thành công"
						});
					}
				});
			}
		})

	});

	$(document).on("click", '.level0 input[type="checkbox"]', function () {
		var id = $(this).attr("level");
		checked = $(this).prop("checked");

		var level1 = $(this).parents("table").find('.level1 input[level="' + id + '"]');
		level1.each(function () {
			$(this).prop("checked", checked);
		});

		var level2 = $(this).parents("table").find('.level2 input[level="' + id + '"]');

		level2.each(function () {
			$(this).prop("checked", checked);
			$(this).trigger('change');
		});
	});

	$(document).on("click", '.level1 input[type="checkbox"]', function () {
		var id = $(this).attr("data-chucnang");
		var level = $(this).attr("level");
		checked = $(this).prop("checked");
		//alert(checked);
		var level2 = $(this).parents("table").find('.level2 input[data-chucnang="' + id + '"]');

		level2.each(function () {
			if (checked) $(this).prop("checked", true);
			else $(this).prop("checked", false);
			//$(this).click();
			$(this).trigger('change');
		});

		var level0 = $(this).parents("table").find('.level0 input[level="' + level + '"]');
		level0.each(function () {
			if (checked) $(this).prop("checked", true);
			else {
				var level1 = $(this).parents("table").find('.level1 input[level="' + level + '"]');
				var tmp = true;
				level1.each(function () {
					if ($(this).prop("checked")) {
						tmp = false;
						return false;
					}
				});
				if (tmp) $(this).prop("checked", false);
			}
		});
	});

	$(document).on("change", '.level2 input[type="checkbox"]', function () {
		var id = $(this).attr("data-chucnang");
		var level = $(this).attr("level");
		checked = $(this).prop("checked");

		var level1 = $(this).parents("table").find('.level1 input[data-chucnang="' + id + '"]');
		level1.each(function () {
			if (checked) $(this).prop("checked", true);
			else {
				var level2 = $(this).parents("table").find('.level2 input[data-chucnang="' + id + '"]');
				var tmp = true;
				level2.each(function () {
					if ($(this).prop("checked")) {
						tmp = false;
						return false;
					}
				});
				if (tmp) $(this).prop("checked", false);
			}
		});

		var level0 = $(this).parents("table").find('.level0 input[level="' + level + '"]');
		level0.each(function () {
			if (checked) $(this).prop("checked", true);
			else {
				var level1 = $(this).parents("table").find('.level1 input[level="' + level + '"]');
				var tmp = true;
				level1.each(function () {
					if ($(this).prop("checked")) {
						tmp = false;
						return false;
					}
				});
				if (tmp) $(this).prop("checked", false);
			}
		});
	});

	$(document).on("change", '.level3 input[type="checkbox"]', function () {
		var id = $(this).attr("data-chucnang");
		var level = $(this).attr("level");
		checked = $(this).prop("checked");

		var level1 = $(this).parents("table").find('.level1 input[data-chucnang="' + id + '"]');
		level1.each(function () {
			if (checked) $(this).prop("checked", true);
			else {
				var level2 = $(this).parents("table").find('.level2 input[data-chucnang="' + id + '"]');
				var tmp = true;
				level2.each(function () {
					if ($(this).prop("checked")) {
						tmp = false;
						return false;
					}
				});
				if (tmp) $(this).prop("checked", false);
			}
		});

		var level0 = $(this).parents("table").find('.level0 input[level="' + level + '"]');
		level0.each(function () {
			if (checked) $(this).prop("checked", true);
			else {
				var level1 = $(this).parents("table").find('.level1 input[level="' + level + '"]');
				var tmp = true;
				level1.each(function () {
					if ($(this).prop("checked")) {
						tmp = false;
						return false;
					}
				});
				if (tmp) $(this).prop("checked", false);
			}
		});
	});


	$("#btnSearch").click(function () {
		$('#datatable-nhomquyen').DataTable().ajax.reload(hiddenButton);
	});

	$("#btnReset").click(function () {
		$("#maNQ").val("");
		$("#tenNQ").val("");
	});
});
function hiddenButton() {
	if ($("#role-nhomquyen-save").val() == "false") {
		$(".add-new").hide();
		$(".edit").hide();
		$(".save").hide();
		$(".add").hide();
	}
	if ($("#role-nhomquyen-delete").val() == "false") {
		$(".delete").hide();
	}
	if ($("#role-nhomquyen-phanquyen").val() == "false") {
		$(".policy").hide();
	}
}	