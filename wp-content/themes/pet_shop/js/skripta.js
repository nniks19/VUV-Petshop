(function($){
    $(document).ready(function(){
        
        $(document).on('submit', '[data-js-form=filter]', function(e){
            e.preventDefault(); // Vise ne osvjezava stranicu kad stisnem na filter
            
            var data = $(this).serialize();
            $.ajax({
                url: wpAjax.ajaxUrl,
                data: data,
                type: 'post',
                success: function(result){
                    $('[data-js-filter=target]').html(result);
                },
                error: function(result){
                    //console.log(result);
                }
            });
            
        });

        $(document).on('submit', '[data-js-form=getcartdata]', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            console.log(data);
            alert("as");
            $.ajax({
                url: wpAjax.ajaxUrl,
                data: data,
                type: 'post',
                success: function(result){
                    $('[data-js-form=getcartdata]').html(result);
                },
                error: function(result){
                    //console.log(result);
                }
            });
        });
        
    });
})(jQuery);


$("#min-price").on("change mousemove", function () {
    min_price = parseInt($("#min-price").val());
    $("#min-price-txt").text(min_price + " KN");
  });
  
  $("#max-price").on("change mousemove", function () {
    max_price = parseInt($("#max-price").val());
    $("#max-price-txt").text(max_price + " KN");
  });


  function alertMe(button, name){
    var artikli = localStorage.getItem('artikli');

    if(artikli){
        if(artikli.split(",").includes($(button).attr("id"))){
            alert("Artikl je već u košarici!");
        }else{
            artikli = artikli +  "," + $(button).attr("id");
            localStorage.setItem('artikli', artikli);
            alert("Uspješno ste dodali artikl u košaricu: \n"+ name);
        }
    }else{
        localStorage.setItem('artikli', $(button).attr("id"));
        alert("Uspješno ste dodali artikl u košaricu: \n"+ name);


    }

}
function myFunction(ovo, priceid, singleprice) {
    singleprice = parseFloat(singleprice);
    newprice = singleprice * ovo.value;
    oldprice = parseFloat($(priceid).html().replace("Cijena: ","").replace(" kn",""));
    if (oldprice > newprice){
        document.getElementById('totalprice').innerHTML = "Cijena: " + (parseFloat(document.getElementById('totalprice').innerHTML.replace("Cijena: ","").replace(" kn","")) - singleprice).toFixed(2) + " kn";
    }
    if (oldprice < newprice){
        document.getElementById('totalprice').innerHTML = "Cijena: " + (parseFloat(document.getElementById('totalprice').innerHTML.replace("Cijena: ","").replace(" kn","")) + singleprice).toFixed(2) + " kn";

    }

    $(priceid).html(newprice.toFixed(2) + " kn");
}

function removeitemfromcart(id){
    total_price = parseFloat(document.getElementById('totalprice').innerHTML.replace("Cijena: ","").replace(" kn",""));
    current_price = parseFloat(document.getElementById("_" + id).innerHTML.replace("Cijena: ","").replace(" kn",""));
    document.getElementById('totalprice').innerHTML = "Cijena: " + (total_price - current_price).toFixed(2) + " kn";
    document.getElementById("item_" + id).remove();
    document.getElementById('cart_count').innerHTML = parseInt(document.getElementById('cart_count').innerHTML) - 1;
    var artikli = localStorage.getItem('artikli');
    artikli = artikli.split(",");
    var newArray = artikli.filter(function(f) { return f !== String(id) })
    localStorage.setItem('artikli', newArray.join());
    if (newArray.length == 0){
        localStorage.removeItem('artikli');
        location.reload();
    }

}