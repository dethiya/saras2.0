$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnDeliver', function () {
        var vehicle_id=$(this).attr("vehicle_id");
        var chassis_no=$(this).attr("chassis_no");
        swal({
            title: "Deliver Chassis#: "+chassis_no,
            text: "Are you sure, you want to deliver this vehicle?",
            icon: "info",
            buttons: {
                cancel: "Discard!",
                confirm: {
                  text: "Confirm!",
                  value: "confirm",
                },
                
              },
            dangerMode: true,
          }).then((value)=>{
            switch (value) {
 
                case "confirm":
                window.location.href='delivery.php?id='+vehicle_id;
                toastr.success("Vehicle with Chassis #: "+chassis_no+" delivered successfully.", "Success");
                break;
             
                default:
                    toastr.info("Vehicle not delivered.", "Info");
              }
          })
    } );
})


$(document).ready(function(){
    var table = $('#data-table-combine').DataTable();

    $('#data-table-combine tbody').on('click', '.btnDeallotment', function () {
        var vehicle_id=$(this).attr("vehicle_id");
        var chassis_no=$(this).attr("chassis_no");
        // console.log(vehicle_id);
        swal({
            title: "Deallot Chassis#: "+chassis_no,
            text: "Are you sure, you want to deallot this vehicle?",
            icon: "info",
            buttons: {
                cancel: "Discard!",
                confirm: {
                  text: "Confirm!",
                  value: "confirm",
                },
                
              },
            dangerMode: true,
          }).then((value)=>{

            switch (value) {
                
                case "confirm":
                    $.ajax({
                        url:'deallotment.php',
                        method:'post',
                        data:{vehicle_id:vehicle_id},
                        success:function(result){
                            toastr.success("Vehicle with Chassis #: "+chassis_no+" deallotted successfully.", "Success");         
                            window.location.href="allotment.php";
                        }
                    })
                // window.location.href='deallotment.php?id='+vehicle_id;
                // toastr.success("Vehicle with Chassis #: "+chassis_no+" deallotted successfully.", "Success");
                break;
             
                default:
                    toastr.info("Vehicle deallotment aborted.", "Info");
              }
          })
          
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

