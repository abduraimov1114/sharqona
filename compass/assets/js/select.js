setInterval(function(){
//alert("Aloo");
    $.ajax({
        url:"exam.php",
        method: "POST",
        success:function(data){
                document.getElementById('divs').innerHTML=data;
                var count = document.getElementById('num').value;
            document.getElementById('count').innerHTML=count;
        }
    })
}, 30000);
data1();
function data1(){
    $.ajax({
        url:"exam.php",
        method: "POST",
        success:function(data){
            document.getElementById('divs').innerHTML=data;
            var count = document.getElementById('num').value;
            document.getElementById('count').innerHTML=count;
        }
    })
}
