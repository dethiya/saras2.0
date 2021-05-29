function outlet_stock() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("outlet_stock").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/outlet-stock.php", true);
        xhttp.send();
    },1000);
}
outlet_stock();

function nexa_live() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("nexa_live").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/nexa-live.php", true);
        xhttp.send();
    },1000);
}
nexa_live();

function commercial_live() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("commercial_live").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/commercial-live.php", true);
        xhttp.send();
    },1000);
}
commercial_live();

function stock_value() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("stock_value").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/stock-value.php", true);
        xhttp.send();
    },1000);
}
stock_value();

function alloted() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("total_alloted").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/alloted.php", true);
        xhttp.send();
    },1000);
}
alloted();

function free() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("total_free").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/free.php", true);
        xhttp.send();
    },1000);
}
free();

function transfers() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("total_transfers").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/transfers.php", true);
        xhttp.send();
    },1000);
}
transfers();

function fpr() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("total_fpr").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/fpr.php", true);
        xhttp.send();
    },1000);
}
fpr();

function indent_notify() {
    setInterval(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("indent_notifications").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "ajax/indent-notification.php", true);
        xhttp.send();
    },1000);
}
indent_notify();
