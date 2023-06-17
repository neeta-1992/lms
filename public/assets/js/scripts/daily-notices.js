const $ProcessNotices = $('button[data-action="process_notices"]');
$(document).on("click", ".dailyNoticeDetails", async function(e) {
    let id = $(this).data('id');
    let account = $(this).data('account');
    const response = await doAjax(`${BASE_URL}accounts/notice/details/${account}/${id}`, "post");
    if (response) {
        htmlAlertModelNotice(response?.template)
    }
});

let resultArrId = [];
$(`#${activePage}-list`).on('check.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table'
    , async function(data, row) {
        console.log(data.type);
        if ($.isArray(row) && data.type == 'check-all') {
            resultArrId = row.map(item => item.id);
        } else if(data.type == 'check') {
            resultArrId.push(row.id)
        }else if(data.type == 'uncheck'){
            resultArrId.remove(row.id);
        }else{
            resultArrId = []; 
        }
})

$(document).on("click", 'button[data-action="process_notices"]', async function(e) {
    if (!isEmptyChack(resultArrId)) {
        let html = await doAjax(`${BASE_URL}daily-notices/daily-notice-process-html`, 'post', {  id: resultArrId})
        if (!isEmptyChack(html)) {
            $("[data-remodal-id=dailyNoticeModel]").find('.template_section').html(html)
            $("[data-remodal-id=dailyNoticeModel]").remodal({  closeOnOutsideClick: true }).open();
        }
    }
});
$(document).on("click", '.processNotices', async function(e) {
     let type = noticeType?.toLowerCase();
     let response = await doAjax(`${BASE_URL}daily-notices/daily-notice-process`,'post',{  id: resultArrId,type:type});
    /*  console.log(response); */
     if(response.status == true){
        textAlertModel(true,response.message);
     }else if(response.status == false){
        textAlertModel(true,response.message);
     }
});


$(document).on("click", '.createdPrint', async function(e) {
    $('.processNotices').removeClass('d-none')
});
$(document).on("click", '.template_section nav ul li a', async function(e) {
    var id = $(this).attr('href');
	$(".template_section nav ul li a").removeClass("active");
	$(this).addClass("active");
	$('.template_section').animate({
		scrollTop: $(id).offset().top-400
	}, 2000);
});
$( document ).ready(function() {
	$(".template_section").scroll(function() {
		var scrollDistance = $(".template_section").scrollTop();
		$('.scrollingsection').each(function(i) {
			if (($(this).position().top-400) <= scrollDistance) {
				$(".template_section nav ul li a").removeClass('active');
				$(".template_section nav ul li a").eq(i).addClass('active');
			}
		});
	}).scroll();
});