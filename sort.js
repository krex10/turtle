function sort(query, sort, filter, s)
{
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("search_results").innerHTML=xmlhttp.responseText;
        }
    }
    var link = "sort.php?q="+query+"&sort="+sort+"&filter="+filter+"&s="+s;
    xmlhttp.open("GET",link,true);
    xmlhttp.send();
}