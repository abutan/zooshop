

//Tooltip on hover
$("[data-toggle='tooltip']").tooltip();

// Makes tooltips work on ajax generated content
$(document).ajaxStop(function () {
    $("[data-toggle='tooltip']").tooltip();
});

$('#list-views').click(function () {
    $('#grid-views').removeClass('active');
    $('.product-layout').removeClass('col-sm-4');
    $('#list-views').addClass('active');
});

$('#grid-views').click(function () {
   $('#list-views').removeClass('active');
   $('.product-layout').addClass('col-sm-4');
   $('#grid-views').addClass('active');
});

$('a.fancybox').fancybox();

$('.attButton').click(function (e) {
    e.preventDefault();
    var modal = $('#attModal');
    modal.modal('show');
    modal.find('#modal-content').load($(this).attr('href'));
});

$('.backPhone').click(function (e) {
    e.preventDefault();
    var modal = $('#phoneModal');
    modal.modal('show');
    modal.find('#modal-content').load($(this).attr('href'));
});

$(document).ready(function () {
    var element = $('.aside-menu a.active');
       element.click(function (e) {
       e.preventDefault();
       $(this).siblings('ul').slideToggle();
       });
});

$('#list-view').click(function () {
    $('#grid-view').removeClass('active');
    $('.product-layout').removeClass('col-sm-4');
    $('#list-view').addClass('active');
});

$('#grid-view').click(function () {
    $('#list-view').removeClass('active');
    $('.product-layout').addClass('col-sm-4');
    $('#grid-view').addClass('active');
});

$('#comments').find('.comment-reply').click(function () {
   var link = $(this);
   var form = $('#reply-block').find('form');
   var comment = link.closest('.comment-item');
   var data = comment.data('id');
    $('input#usercommentform-parentid').val(data);
    $('input#anonymouscommentform-parentid').val(data);
    /*form.css('display', 'block');*/
    form.css({'display':'block', 'border-top':'1px dotted #007100', 'margin-top':'15px'}).detach().appendTo($(this).parent().parent().parent('div'));
    return false;
});