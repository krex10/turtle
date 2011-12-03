function more_info (list_info) {
    $("#search_results").on("mouseover", tester(list_info));
}

function tester (list_info) {
    var list_length = list_info.length;
    var info;
    for (var i=0; i < list_length; i++) {
        var selector_id = "."+i;
        info = "Price: $ "+list_info[i][2]+"</br>Distance: "+list_info[i][3]+" km<br/>Available: "+list_info[i][4]
            +"<br/>Utilities: "+list_info[i][5]+"<br/>Lease: "+list_info[i][6]+"<br/>Furnished: "+list_info[i][7]
            +"<br/>Rooms: "+list_info[i][8];
        $(selector_id).qtip({
        content: info,
        show: 'mouseover',
        hide: 'mouseout', });
    }
}