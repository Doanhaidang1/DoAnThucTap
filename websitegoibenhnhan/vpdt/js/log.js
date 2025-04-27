$(document).ready(function () {
	$(document).on("click", ".delete", function () {
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
			title: "Đã xóa log thành công"
		});
		deleteData($('table'), $(this), $("#ULocal").val() + 'log/deleteLog/', 'Ngươi dùng đã được xóa thành công.');
	});
	hiddenButton();
});
function deleteLog(id, msg) {
	if (confirm(msg)) {
		document.getElementById("id").value = id;
		document.getElementById("cmd").value = "201";
		return true;
	}
	return false;
}
function hiddenButton() {
	if ($("#role-log-deleteLog").val() == "false") {
		$(".delete").hide();
	}
}	
