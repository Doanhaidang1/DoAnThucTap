/* DATA TABLES */
var table;
function init_DataTables() {
	console.log('run_datatables');
	table = $('#datatable-hang').DataTable({
		"ajax":
		{
			url: $("#ULocal").val() + 'hang/getData/',
			type: 'POST',
			data: function (d) {
				return $.extend({}, d, {
					"Id_hang": $("#Id_hang").val(),
					"Ten_hang": $("#Ten_hang").val()
				});
			},
			error: function (response) {
				alert(JSON.stringify(response))
			},
		},
		"pageLength": $('#pageLength').val(),
		"searching": false,
		"order": [[0, "desc"]],
		scrollY: '50vh',
		scrollCollapse: true,
		dom: '<"dt-toolbar">Bfrtlpi',
		buttons: [
			{
				extend: "excel",
				className: "btn-sm"
			},
			{
				extend: "pdfHtml5",
				className: "btn-sm"
			},
			{
				extend: "print",
				className: "btn-sm"
			}
		],
		responsive: true,
		bAutoWidth: false,
		"columnDefs": [
			{
				"targets": 0,
				"width": '5%',
				"className": "text-center",
				"sortable": false,
				"render": function (data, type, row, meta) {
					return (meta.row + 1);//[row].join('');
				}
			},
			{
				"targets": 1,
				"width": '5%',
				"data": "Id_hang"
			},
			{
				"targets": 2,
				"width": '25%',
				"data": "Ten_hang"
			},
			{
				"targets": 3,
				"width": '5%',
				"data": "DVT"
			},
			{
				"targets": 4,
				"width": '10%',
				"data": "Kho",
				"render": function (data, type, row) {
					var valueSelect = $("#kho option[value='" + data + "']").text();
					return '<input type="hidden" id = "selectid" value="' + data + '">' + valueSelect;
				}
			},
			{
				"targets": 5,
				"width": '5%',
				"data": "Lo"
			},
			{
				"targets": 6,
				"width": '5%',
				"data": "Date"
			},
			{
				"targets": 7,
				"width": '5%',
				"data": "SL"
			},
			{
				"targets": 8,
				"width": '5%',
				"data": "Gia"
			},
			{
				"targets": 9,
				"width": '5%',
				"data": "Nguon"
			},
			{
				"targets": 10,
				"width": '5%',
				"data": "Id_hang",
				"sortable": false,
				"render": function (data, type, row) {
					var save = "", update = "", del = "", print = "", id = "", lock = "";
					id = '<input type="hidden" name = "id" id = "id" value="' + data + '">';
					save = '<a id="btn-update" class="add" title="Lưu" data-toggle="tooltip"><i class="material-icons">save</i></a>';
					update = '<a class="edit" title="Sửa" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>';
					del = '<a class="delete" title="Xóa" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
					print = '<a class="print" title="Print" data-toggle="tooltip" style="margin: 0;"><i class="material-icons">print</i></a>';
					// if(row["adminType"] == '0'){
					// 	del = '<a class="delete" title="Xóa" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';					
					// 	// polyci = '<a class="polici" title="Phân quyền" data-toggle="tooltip"><i class="material-icons">vpn_lock</i></a>';
					// 	lock = '<a class="lock" title="Mở Khóa người dùng" data-toggle="tooltip" data-id="'+row["nd_block"]+'"><i class="material-icons">lock</i></a>';
					// 	if(row["nd_block"]=='0') {
					// 		lock = '<a class="lock" title="Khóa người dùng" data-toggle="tooltip" data-id="'+row["nd_block"]+'"><i class="material-icons">lock_open</i></a>';
					// 	}						
					// }
					return [id, save, update, print, lock, del].join('');
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
			$("div.dt-toolbar").html('<button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Thêm mới</button>' +
				'<button type="button" class="btn btn-info save"><i class="fa fa-floppy-o"></i> Cập nhật</button>');
			hiddenButton();
			// Append table with add row form on add new button click
			$(".add-new").click(function () {
				addRowInput($('#datatable-hang'), 1);
			});

			// save new row
			$(".save").click(function () {
				if (confirm("Bạn có chắc muốn cập nhật dữ liệu không !")) {
					if (saveData($('#datatable-hang'), $("#ULocal").val() + 'hang/savehang/', "'Người dùng đã được cập nhật thành công.'")) {
						$('#datatable-hang').DataTable().ajax.reload(hiddenButton);
					}
				}
			});
		}
	});
};

$(document).ready(function () {

	init_DataTables();

	$('[data-toggle="tooltip"]').tooltip();
	// update data
	$(document).on("click", ".add", function () {
		if (confirm("Bạn có chắc muốn cập nhật dữ liệu này không !")) {
			updateData($(this), $("#ULocal").val() + 'hang/savehang/', 'Ngươi dùng đã được cập nhật thành công.');
			$('#datatable-hang').DataTable().ajax.reload(hiddenButton);
		}
	});

	// Edit row on edit button click
	$(document).on("click", ".edit", function () {
		addInput($('#datatable-hang'), $(this).closest('tr'));
		$(this).closest('tr').find(".add, .edit").toggle();
	});

	// Delete row on delete button click
	$(document).on("click", ".delete", function () {
		if (confirm("Bạn có chắc muốn xóa dữ liệu này không !")) {
			deleteData(table, $(this), $("#ULocal").val() + 'hang/deletehang/', 'Ngươi dùng đã được xóa thành công.')
			//table.ajax.reload();				
		}
	});

	$("#btnSearch").click(function () {
		$('#datatable-hang').DataTable().ajax.reload(hiddenButton);
	});


	// Lock hang
	$(document).on("click", ".lock", function () {
		if (confirm("Bạn có chắc muốn khóa/mở khóa người dùng này không !")) {
			var obj = $(this);
			var Id_hang = getId($(this));
			var lock = $(this).attr("data-id");
			url = $("#ULocal").val() + 'hang/lockhang/';
			// Save data
			$.ajax({
				url: url,
				data: {
					'Id_hang': Id_hang,
					'lock': lock
				},
				type: 'POST',
				dataType: "json",
				cache: false,
				//async: false,
				error: function (htmlText) {
					alert("loi :" + JSON.stringify(htmlText));
				},
				success: function (json) {
					if (json == '1') {
						obj.find(".material-icons").html("lock");
						$(obj).prop('title', 'Khóa người dùng');
					}
					else {
						obj.find(".material-icons").html("lock_open");
						$(obj).prop('title', 'Mở Khóa người dùng');
					}
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		}
	});

	$(".custom-file-input").on("change", function () {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});

	$(document).on("submit", "#formImport", function (e) {
		e.preventDefault();

		if (!confirm("Bạn có chắc muốn import dữ liệu này không !")) {
			return false;
		}

		obj = $(this);
		url = $("#ULocal").val() + 'nhapdanhsach/importDS/';

		$.ajax({
			url: url,
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function () {
				obj.siblings(".err").fadeOut();
			},
			success: function (data) {
				if (data.error == 'invalid') {
					obj.siblings(".err").html("Chỉ chấp nhận các file .xls,.xlsx").fadeIn();
				}
				else {
					obj.trigger("reset");
					obj.find(".custom-file-label").removeClass("selected").html("");
					$(".custom-file-label").text("Choose file");
					$(".err").text("");
					alert("Đã import danh sách tiêm.");
					$("#modal-import").modal("hide");
					$("#btnSearch").click();
				}
			},
			error: function (json) {
				alert("loi" + JSON.stringify(json));
				//$("#err").html(e).fadeIn();
			}
		});
	});



	$("#btnReset").click(function () {
		$("#Id_hang").val("");
		$("#Ten_hang").val("");
	});
	$(document).on("click", ".print", function () {

		var Id_hang = getId($(this));

		url = $("#ULocal").val() + 'hang/getThe/';
		// Save data
		$.ajax({
			url: url,
			data: {
				'Id_hang': Id_hang
			},
			type: 'POST',
			dataType: "json",
			cache: false,
			//async: false,
			error: function (json) {
				alert("loi :" + JSON.stringify(json));
			},
			success: function (json) {
				if (json.status == 'success') {
					hang = json.hang;
					// listlantiem = json.chiTiet;
					// if(listlantiem!=false){	
					img = json.img;
					// $("#printpage .header-right").html('<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=http%3A%2F%2Ftracuu%2Ebvtn%2Eorg%2Evn%2F%3Fcv9='+benhnhan.bnId+'%26token='+benhnhan.token+'&choe=UTF-8"/>');
					$("#printpage .header-right").html(img);

					$("#printpage #pTen_hang").html(hang.Ten_hang);
					$("#printpage #pDVT").html(hang.DVT);
					// gioitinh = "Nam/Male";
					// if(benhnhan.gioiTinh == "Nữ"){
					// 	gioitinh = "Nữ/Female"
					// }
					var valueSelect = $("#kho option[value='" + hang.Kho + "']").text();
					$("#printpage #pKho").html(valueSelect);
					$("#printpage #pLo").html(hang.Lo);
					$("#printpage #pDate").html(hang.Date);
					$("#printpage #pSL").html(hang.SL);
					$("#printpage #pGia").html(hang.Gia);
					$("#printpage #pNguon").html(hang.Nguon);

					// const lanTiem = [1, 2, 3];						
					// var rowCount = 1;	
					// var	mui = "st";
					// $.each(listlantiem, function(i, item) {
					// 	rowCount = item.mTiem;
					// 	$.each(lanTiem, function(j, lan) {
					// 		if(item.mTiem == lan){
					// 			lanTiem[j] = 0;
					// 		}
					// 	});

					// 	if(rowCount == 2) mui = "nd";
					// 	if(rowCount == 3) mui = "rd";

					// 	var today = new Date(item.ngayTiem);
					// 	var dd = String(today.getDate()).padStart(2, '0');
					// 	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
					// 	var yyyy = today.getFullYear();

					// 	today =  dd + '/' + mm + '/' + yyyy;

					// 	$("#printpage #plantiem"+rowCount).html('Mũi '+rowCount+'/<span class="font-italic">'+rowCount+'<sup>'+mui+'</sup></span>Dose');
					// 	$("#printpage #pngaytiem"+rowCount).html(today);
					// 	$("#printpage #ploaivaccine"+rowCount).html(item.loaiVaccine);	
					// 	$("#printpage #phang"+rowCount).html(item.hangSX);
					// 	$("#printpage #plo"+rowCount).html(item.loSX);		

					// 	rowCount++;
					// });
					// var	mui = "st";

					// $.each(lanTiem, function(j, lan) {
					// 	if(lan > 0){
					// 		rowCount = lan;
					// 		if(rowCount == 2) mui = "nd";
					// 		if(rowCount == 3) mui = "rd";
					// 		$("#printpage #plantiem"+rowCount).html('Mũi '+rowCount+'/<span class="font-italic">'+rowCount+'<sup>'+mui+'</sup></span>Dose');
					// 		$("#printpage #pngaytiem"+rowCount).html("");
					// 		$("#printpage #ploaivaccine"+rowCount).html("");	
					// 		$("#printpage #phang"+rowCount).html("");
					// 		$("#printpage #plo"+rowCount).html("");
					// 	}
					// });

					printData("section-to-print");
					// }
					// else{
					// 	alert("Chưa có dữ liệu tiêm.");
					// }
				} else if (json.status == 'error') {
					alert("Dữ liệu in GXN chưa đầy đủ.");
				}
			}
		});
	});
});

function printData(objId) {
	var contents = $("#" + objId).html();
	var frame1 = $('<iframe />');
	frame1[0].name = "frame1";
	frame1.css({ "position": "absolute", "top": "-1000000px" });
	$("body").append(frame1);
	var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
	frameDoc.document.open();
	//Create a new HTML document.
	frameDoc.document.write('<html><head><title>DIV Contents</title>');
	//Append the external CSS file.		
	frameDoc.document.write('<link href="' + $("#ULocal").val() + 'css/bootstrap.min.css" rel="stylesheet" type="text/css" />');
	frameDoc.document.write('<link href="' + $("#ULocal").val() + 'css/font-awesome.min.css" rel="stylesheet" type="text/css" />');
	frameDoc.document.write('<link href="' + $("#ULocal").val() + 'css/custom.css" rel="stylesheet" type="text/css" />');
	frameDoc.document.write('<link href="' + $("#ULocal").val() + 'css/print.css?2" rel="stylesheet" type="text/css" />');
	frameDoc.document.write('<style>@page { size: A5 }</style>');
	frameDoc.document.write('</head><body class="A5">');
	//Append the DIV contents.
	frameDoc.document.write('<section class="sheet padding-15mm">');
	frameDoc.document.write(contents);
	frameDoc.document.write('</section>');
	frameDoc.document.write('</body></html>');
	frameDoc.document.close();
	setTimeout(function () {
		window.frames["frame1"].focus();
		window.frames["frame1"].print();
		frame1.remove();
	}, 500);
}
function hiddenButton() {
	if ($("#role-hang-saveUserhang").val() == "false") {
		$(".add-new").hide();
		$(".edit").hide();
		$(".save").hide();
	}
	if ($("#role-user-deleteUser").val() == "false") {
		$(".delete").hide();
	}

}	