
function clicker(that){
	var myshow = that.id;

	window.location.href = myshow;
}

$(document).ready(function() {
   $("#sort").DataTable({
      columnDefs : [
    { type : 'date', targets : [3] }
],  
   });
});
