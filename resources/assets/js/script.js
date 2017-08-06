$(document).ready(function () {
    
    //select one article
    $('.select-article').click(function () {
        if ($(this).prop('checked') == true) {
            $(this).parent().parent().addClass('info');
        } else {
            $(this).parent().parent().removeClass('info');
        }
    });

    // select all articles 
    $('#select-all-article').click(function () {
        var article_selector = '.select-article';
        if ($(this).prop('checked') == true) {
            $(article_selector).prop('checked', true);
            $(article_selector).parent().parent().addClass('info');
        } else {
            $(article_selector).prop('checked', false);
            $(article_selector).parent().parent().removeClass('info');
        }
    });
});