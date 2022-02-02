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
            if(cartValidation()){
            $.ajax({
                    url: wpAjax.ajaxUrl,
                    data: data + localStorage.getItem('artikli'),
                    type: 'post',
                    success: function(result){
                        localStorage.removeItem('artikli');
                        $('#kosaricca').html('<div class="alert alert-success container text-center" role="alert"><h4 class="alert-heading">Narudžba zaprimljena!</h4><p>Uskoro će vam stići email sa detaljima i potvrdom narudžbe</p><hr><p class="mb-0">Hvala vam na Vašoj kupnji i povjerenju!</p></div>');
                    },
                    error: function(result){
                        console.log(result);
                    }
            });
            }
            
        });
        
    });
})(jQuery);

function cartValidation(){
    allvalid = true;
    if (buyertypeValidation() == false){
        allvalid=false;
    }
    else if (nameValidation() == false){
        allvalid = false;
    }
    else if (lastnameValidation() == false){
        allvalid = false;
    }
    else if (citynameValidation() == false){
        allvalid = false;
    } else if (oibValidation() == false){
        allvalid=false;}
    else if (addressValidation() == false){
        allvalid = false;
    }
    else if (homenumberValidation() == false){
        allvalid = false;
    } 
    else if (countryValidation() == false){
        allvalid=false;
    }    
    else if (zipValidation() == false){
        allvalid=false;
    }else if (phonenumValidation() == false){
        allvalid=false;
    }
    else if (emailValidation() == false){
        allvalid=false;
    }

    return allvalid;
}
function buyertypeValidation(){
    if (!$('#buyer_type').val()) {
        alert('Obavezan je odabir vrste kupca!');
        return false;
    }
}
function nameValidation(){
    if (!$('#firstName').val()) {
        alert('Unesite svoje ime!');
        return false;
    }
}
function lastnameValidation(){
    if (!$('#lastName').val()) {
        alert('Unesite svoje prezime!');
        return false;
    }
}
function citynameValidation(){
    if (!$('#city').val()) {
        alert('Unesite Vaš grad!');
        return false;
    }
}
function addressValidation(){
    if (!$('#address').val()) {
        alert('Unesite Vašu ulicu!');
        return false;
    }
}
function homenumberValidation(){
    if (!$('#homenumber').val()) {
        alert('Unesite Vaš kućni broj!');
        return false;
    }
}
function countryValidation(){
    if (!$('#country').val()) {
        alert('Unesite državu iz koje dolazite!');
        return false;
    }
}
function zipValidation(){
    if (!$('#zip').val()) {
        alert('Unesite poštanski broj mjesta iz kojeg dolazite!');
        return false;
    }
}
function emailValidation(){
    if (!$('#email').val()) {
        alert('Unesite vašu email adresu!');
        return false;
    }else {
        if(!isEmail($('#email').val())){
            alert("Email adresa nije dobroga formata");
            return false;
        }
    }
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
function oibValidation(){
    if (!$('#oib').val()) {
        alert('Unesite OIB!');
        return false;
    }
}
function phonenumValidation(){
    if (!$('#phonenum').val()) {
        alert('Unesite broj mobitela!');
        return false;
    }
}

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
