//いいね機能
window.onload = function(){
$(document).on('click','.favorite_btn',function(e){
        e.stopPropagation();
        var $this = $(this),
        user_id = $(e.currentTarget).data('user_id');
        recipe_id = $(e.currentTarget).data('recipe_id');
        $.ajax({
                type: 'POST',
                url: './new.php',
                dataType: 'json',
                data: { user_id: user_id,
                        recipe_id: recipe_id}
        }).done(function(data){
                location.reload();
        }).fail(function(e) {
                location.reload();
        });
});
};
