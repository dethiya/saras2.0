
$(document).ready(function(){
    
    $('#is_finance').on('change', function () {
        if(this.value === "Yes"){
            $(".display_div").show();
            $(".cash").hide();
        } else {
            $(".display_div").hide();
            $(".cash").show();
        }

        var finance_value=$("#is_finance").val();
        // console.log(finance_value);
        $.ajax({
            url:'ajax/loadstages.php',
            method:'post',
            data: 'finance_value='+finance_value
        }).done(function (stages) {
            // console.log(stages);
            stages=JSON.parse(stages);
            stages.forEach(function(stage){
                $('#stages').append('<option value='+stage.id+'>'+stage.stage_name+'</option>')
            })
        })

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

