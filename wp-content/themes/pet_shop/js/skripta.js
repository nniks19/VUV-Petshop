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
                    console.log(result);
                }
            })
            //console.log(data);
        });
    });
})(jQuery);

$("#min-price").on("change mousemove", function () {
    min_price = parseInt($("#min-price").val());
    $("#min-price-txt").text(min_price + " kn");
  });
  
  $("#max-price").on("change mousemove", function () {
    max_price = parseInt($("#max-price").val());
    $("#max-price-txt").text(max_price + " kn");
  });