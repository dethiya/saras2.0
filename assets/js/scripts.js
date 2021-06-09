
$(document).ready(function(){
    

    $('#is_finance').on('change', function () {
        $('#mssf_id').prop('disabled', true);
        $('#mssf_login_dt').prop('disabled', true);
        $('#finance_type').prop('disabled', true);
        $('#fin_bank_id').prop('disabled', true);
        $('#branch').prop('disabled', true);
        $('#bank_executive').prop('disabled', true);
        if ($(this).val() == 'Yes') {
          $('#mssf_id').prop('disabled', false);
          $('#mssf_login_dt').prop('disabled', false);
          $('#finance_type').prop('disabled', false);
          $('#fin_bank_id').prop('disabled', false);
          $('#branch').prop('disabled', false);
          $('#bank_executive').prop('disabled', false);
        }
        
    });


    $('#is_exchange').on('change', function () {
        if(this.value === "Yes"){
            $(".display_div").show();

        } else {
            $(".display_div").hide();

        }
    });


    




    function loadDoc() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("notification_allotments").innerHTML = this.responseText;
                // document.getElementById("allotments").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/notification.php", true);
        xhttp.send();
    },1000);
}
    loadDoc();

    function delivery() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deliveries").innerHTML = this.responseText;
                // document.getElementById("allotments").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET", "ajax/deliveries.php", true);
        xhttp.send();
    },1000);
}
    delivery();


    function new_indents() {
        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("new_indents").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajax/new-indents.php", true);
            xhttp.send();
        },1000);
    }
    new_indents();

    function new_allotments() {
        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("new_allotments").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajax/new-allotment.php", true);
            xhttp.send();
        },1000);
    }
    new_allotments();

    function new_delivery() {
        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("new_delivery").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajax/new-delivery.php", true);
            xhttp.send();
        },1000);
    }
    new_delivery();



    // //nac live stock
    // function nac_live() {
    //     setInterval(function () {
    //         var xhttp = new XMLHttpRequest();
    //         xhttp.onreadystatechange = function() {
    //             if (this.readyState == 4 && this.status == 200) {
    //                 document.getElementById("nac").innerHTML = this.responseText;
    //             }
    //         };
    //         xhttp.open("GET", "ajax/nexa.php", true);
    //         xhttp.send();
    //     },1000);
    // }
    // nac_live();



    //deallot link
    $(".deallot_link").on('click', function(){
        var id = $(this).attr("rel");
        var deallot_url = "deallotment.php?id="+ id +" ";
        $(".modal_deallot_link").attr("href", deallot_url);
        $("#modal-alert-deallot").modal('show');
    });
    //raise indent
    $(".raise_link").on('click', function(){
        var id = $(this).attr("indent");
        var raise_indent_url = "raise-indent.php?id="+ id +" ";
        $(".modal_indent_link").attr("href", raise_indent_url);
        $("#modal-indent").modal('show');
    });

    //issue link
    $(".issue_link").on('click', function(){
        var id = $(this).attr("issue");
        var issue_url = "branch-transfer.php?id="+ id +" ";
        $(".modal_issue_link").attr("href", issue_url);
        $("#modal-issue").modal('show');
    });
    //receive link
    $(".receive_link").on('click', function(){
        var id = $(this).attr("receive");
        var receive_url = "receive-indent.php?id="+ id +" ";
        $(".modal_receive_link").attr("href", receive_url);
        $("#modal-receive").modal('show');
    });
});


// swap vehicle fetch vintage of chassis one 
    $(document).on('change','#chassis_prev', function(){
        $('.vintage-target').html( $('option:selected', this).data('vintage') );
    })
// swap vehicle fetch vintage of chassis two 
$(document).on('change','#chassis_next', function(){
    $('.vintage-target2').html( $('option:selected', this).data('vintage') );
})


$(document).ready(function() {
    $('#chassis_prev').select2();
    $('#chassis_next').select2();
});

// Toggle Vehicle Types
$(document).ready(function(){
    $(document).on('click','.btnActivate',function(){
        var vehicle_id=$(this).attr("vehicle_id");
        var vehicle_status=$(this).attr("vehicle_status");
        // console.log(vehicle_id+','+vehicle_status);
        var data = new FormData();
        data.append("vehicle_id",vehicle_id);
        data.append("vehicle_status",vehicle_status);
        $.ajax({
            url:'ajax/vehicles.ajax.php',
            method:'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success:function(answer){
                toastr.success("Vehicle type updated successfully.","Success");
                toastr.options = {
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                  }
            }
        })
        if(vehicle_status == 0){
            $(this).removeClass('text-primary');
            $(this).addClass('text-danger');
            $(this).html('Type I');
            $(this).attr('vehicle_status',1);
        }else{
            $(this).addClass('text-primary');
            $(this).removeClass('text-danger');
            $(this).html('Type II');
            $(this).attr('vehicle_status',0);
        }
    })
})