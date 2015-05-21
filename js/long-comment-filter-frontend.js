/**
 * Filter comments that are too long 
 */

jQuery(function($){
    $('#commentform').submit(function(e){
        var comment = $('#comment').val().replace(/\s+/g, ' ').replace(/^\s+|\s+$/g, '');
        var filterType = long_comment_settings.filter_type;
        var maxCount = long_comment_settings.max_count;
        var filterMessage = long_comment_settings.filter_message
                                .replace('%length%', maxCount)
                                .replace('%type%', filterType);

        if ('words' === filterType && comment.split(' ') > maxCount){
            alert(filterMessage);
            e.preventDefault();
            return false;
        } else if ('characters' === filterType && comment.length > maxCount) {
            alert(filterMessage);
            e.preventDefault();
            return false;
        }

        return true;
    });
});
