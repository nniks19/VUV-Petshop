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