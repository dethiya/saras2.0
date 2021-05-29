$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnDeliver', function () {
        var vehicle_id=$(this).attr("vehicle_id");
        var chassis_no=$(this).attr("chassis_no");
        if(confirm("Are you sure, you want to deliver this vehicle (Chassis #:"+chassis_no+")?")){
            window.location.href='delivery.php?id='+vehicle_id;
            return true;
        }
    } );
})

$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnDeallotment', function () {
        var vehicle_id=$(this).attr("vehicle_id");
        var chassis_no=$(this).attr("chassis_no");
        if(confirm("Are you sure, you want to deallot this vehicle (Chassis #:"+chassis_no+")?")){
            window.location.href='deallotment.php?id='+vehicle_id;
            return true;
        }
    } );
});

$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnRaiseIndent', function () {
        var vehicle_id=$(this).attr("vehicle_id");
        var chassis_no=$(this).attr("chassis_no");
        if(confirm("Are you sure, you want to raise indent for this vehicle \n(Chassis #:"+chassis_no+")?")){
            window.location.href='raise-indent.php?id='+vehicle_id;
            return true;
        }
    } );
})

$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnCancelIndent', function () {
        var indent_id=$(this).attr("indent_id");
        var chassis_no=$(this).attr("chassis_no");
        if(confirm("Are you sure, you want to cancel the indent for this vehicle \n(Chassis #:"+chassis_no+")?")){
            window.location.href='raise-indent.php?id='+indent_id;
            return true;
        }
    } );
})

