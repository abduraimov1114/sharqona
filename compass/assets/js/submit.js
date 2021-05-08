function online_submit1(val,id){
    alert(val);
    $.ajax({
        url: "select_buyers.php",
        method: "POST",
        data: {value: id},
        success: function (data){
            //alert(data);
           document.getElementById("list").innerHTML=data;
        }
    })
}
