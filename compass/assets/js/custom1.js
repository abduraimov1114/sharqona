$(document).ready(function (){
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        }
        return result;
    }
    var oTable=document.getElementById('myTable');
    var length = Number(oTable.rows.length);
    var update_id = Number(findGetParameter('update'));
    var count1=1;
    for(var k=0;k<=length;k++) {
        var id = oTable.rows.item(k).cells.item(0).textContent;
        var is_product = oTable.rows.item(k).cells.item(6).textContent;
        if (update_id == id && is_product == 1) {
            var buyer_id = oTable.rows.item(k).cells.item(1).textContent;
            var ps_id = Number(oTable.rows.item(k).cells.item(3).textContent);
            var count = oTable.rows.item(k).cells.item(4).textContent;
            var one_price = oTable.rows.item(k).cells.item(5).textContent;
            count1++;
            // Define counter
            var a = $('#products').find('.row-item').length;

            // Define products template
            var prTemplate = $('#pr_template .pr-row').clone();

            if ($(this).closest('.item-table').find('.row-item').length) {
                if ($(this).closest('.item-table').find('.row-item:last select').val() == '')
                    return false;
            }
            // Increase counter by one
            a++;

            // Loop through each element
            prTemplate.clone()
                .find('.pr-row-num').each(function () {

                    // Update row number
                    $(this).html(a);

                }).end()
                .find('select').each(function () {

                    // Update ID
                    var newId = this.id + a;
                    this.id = newId;
                    // Update name
                    var newName = this.name.replace(/__i__/g, a);
                    this.name = newName;
                    //$(newId).val(ps_id); // Select the option with a value of '1'
                    //$(newId).trigger('change')

                }).end()
                .find('option').each(function () {
                    // Update ID
                    var newId = this.id;
                    //alert(ps_id);
                    var value1 = this.value;
                    if (ps_id == value1) {
                        this.selected = true;
                    }
                    //alert(vale);
                    // Update name
                }).end()
                .find('.pr-price input').each(function () {

                    // Update ID
                    var newId = this.id + a;
                    this.id = newId;

                    // Update name
                    var newName = this.name.replace(/__i__/g, a);
                    this.name = newName;

                }).end()
                .find('.pr-quantity input').each(function () {

                    // Update ID
                    var newId = this.id + a;
                    this.id = newId;
                    this.value = count;
                    // Update name
                    var newName = this.name.replace(/__i__/g, a);
                    this.name = newName;


                }).end()
                .find('.pr-total input').each(function () {

                    // Update ID
                    var newId = this.id + a;
                    this.id = newId;

                    // Update name
                    var newName = this.name.replace(/__i__/g, a);
                    this.name = newName;

                }).end()
                .find('.pr-remove a').each(function () {

                    // Update ID
                    var newId = this.id + a;
                    this.id = newId;

                    // Update name
                    var newName = this.name + a;
                    this.name = newName;

                }).end()
                .appendTo('#products table tbody');
            //var bbb=document.getElementById("id_"+ps_id).textContent;
            //alert(bbb);
            //alert(aaa);
            $('button[name=confirm_outgoings]').prop('disabled', true);
//    step 1////////////////////////////////////////////////////////////////
            setTimeout(function () {
                calculateByPrPriceOrQuantiry(e);
                subtotal($(e.currentTarget));
            }, 100);
//    step 2
            var pr_price = $(this).find(':selected').data('price');
            //alert(pr_price);
            var pr_left = $(this).find(':selected').data('left');
            const parentItem = $(this).closest('.row-item');
            // Set product details' values
            parentItem.find('.item-price').val(pr_price);
            if (parentItem.find('.item-left').length)
                parentItem.find('.item-left').text(pr_left);

            // Calculate total product price before changing quantity by hand
            var pr_quantity = parentItem.find('.item-quantity').val();
            var pr_total = pr_price * pr_quantity;
            parentItem.find('.item-price').val(pr_total);
            // Now calculate subtotal
            // text += "<br>The number is " + i;
//   step 3
            function calculateByPrPriceOrQuantiry(e) {
                // console.log(e.currentTarget);calculateByPrPriceOrQuantiry

                var element = e.currentTarget;
                // console.log(element);
                var itemParent = $(element).closest('.row-item');
                var pr_quantity = itemParent.find("input.item-quantity").val();
                // console.log('Quantity ' + pr_quantity);


                var pr_price = itemParent.find("input.item-price").val();
                // console.log('Price: ' +  pr_price);

                var pr_total = pr_price * pr_quantity;
                // console.log(pr_total);

                itemParent.find(".item-total").val(pr_total);

            }
//    step 4
            // Calculate subtotal
            function subtotal(element) {
                var pr_subtotal = 0;
                element.closest('.item-table').find('input.item-total').each(function () {
                    if ($(this).val() != '')
                        pr_subtotal = pr_subtotal + parseInt($(this).val());
                });

                element.closest('.item-table').find('.subtotal').val(pr_subtotal);
                calSumTotal();
            }
//    step 5
            function calSumTotal(){
                var total = 0;
                $('.subtotal').each(function () {
                    if ($(this).val() != '')
                        total = total + parseInt($(this).val());
                })
                $('#total').val(total);
            }
//    step 6

        }
    }
});