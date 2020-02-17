$(document).ready(function () {
    load();
});


function load() {
    setTimeout(function () {
        count();
        load();
       }, 200);
}


function count() {
    $('#count').load("query/counter.php")
 }
