document.addEventListener('alpine:init', () => {
    Alpine.data('mailBox', () => ({
      /*   quoteId: (editArr?.id ?? null), */
        tab: 'inboxMail',
        labels: 'newMail',
        labelUser: null,
        page : 1,
        selectAll: false,
        search: null,
        typeButton: null,
        mailId: null,
        unreadMailInbox: null,
        selectedMailBox: [],
        qId :null,
        qId :null,
        isdraftsMail :false,
        init() {
           /*  console.log(editArr); */
            this.qId = typeof editArr !== 'undefined' ? editArr?.id : null ;
            this.vId = typeof editArr !== 'undefined' ? editArr?.vid : null ;
            $('.loadhideContent').removeClass('d-none');
            this.unreadMessageCount();
            if ($('#to').length > 0) {
                remotelyDropDown("#to", 'common/mail-send-user')
            }

            if ($('#cc').length > 0) {
                remotelyDropDown("#cc", 'common/mail-send-user')
            }
        },pagination(page) {
            this.page = page;
        },refreshMail() {
            this.page = 1;
            this.unreadMessageCount();
			this.inboxMail();
        },
        toggleAllCheckboxes() {
            this.selectAll = !this.selectAll
            this.selectedMailBox = [];
            checkboxes = document.querySelectorAll('input[name=mailbox]');
            [...checkboxes].map((el) => {
                el.checked = this.selectAll;
                (this.selectAll) ? this.selectedMailBox.push(el.value): this.selectedMailBox = [];
            })
        },
        unreadMessageCount() {
            const unreadResponse = doAjax(BASE_URL + 'in-mail/unread-count', 'post', {
                _token: $('meta[name="csrf-token"]').attr('content'),qId:this.qId,vId:this.vId
            }, null, null, false).then((data) => {
                this.unreadMailInbox = isEmptyChack(data?.count) ? null : data?.count;
				$(".inboxcount").text(this.unreadMailInbox);
            }).catch((err) => {
                console.error(err);
            });
        },
        unreadMail(id) {
            if (!isEmptyChack(id)) {
                 this.selectedMailBox.push(id)
            }
			else{
			this.selectedMailBox=[];
			checkboxes = document.querySelectorAll('input[name=mailbox]');
            [...checkboxes].map((el) => {
				if(el.checked){
					this.selectedMailBox.push(el.value)
				}
            })
			}
            if (!isEmptyChack(this.selectedMailBox)) {
                const unreadResponse = doAjax(BASE_URL + 'in-mail/unread-mail', 'post', {
                    ids: this.selectedMailBox
                }, null, null, false).then((data) => {
					this.unreadMessageCount()
                    this.selectedMailBox = [];
                    this.selectAll = false;
                    this.inboxMail();
                    $('input[name=mailbox],.allsekect').prop('checked', false);
                }).catch((err) => {
                    console.error(err);
                });
            }
        },
        deleteMail(element) {
            let deleteData = false;
            let drafts = false;
            if (!isEmptyChack(element)) {
                let id = element.getAttribute('data-id');
                drafts = element.getAttribute('data-drafts');
                deleteData = true;
                this.selectedMailBox.push(id)
            }
			else{
			this.selectedMailBox=[];
			checkboxes = document.querySelectorAll('input[name=mailbox]');
            [...checkboxes].map((el) => {
				if(el.checked){
					this.selectedMailBox.push(el.value)
				}
            })
			}
            if (!isEmptyChack(this.selectedMailBox)) {
                const unreadResponse = doAjax(BASE_URL + 'in-mail/deletet-mail', 'post', {
                    ids: this.selectedMailBox, delete: deleteData, drafts: drafts, type : this.tab,qId:this.qId,vId:this.vId
                }, null, null, false).then((data) => {
                    this.selectedMailBox = [];
                    this.selectAll = false;
                    if (drafts ==false) {
                        this.inboxMail();
                    }
					else{
                        this.draftsMail()
                    }
                    if (element) {
                        $(element).parents('.inmail_tab_list_heading').remove();
                    }
                    $('input[name=mailbox],.allsekect').prop('checked', false);
                }).catch((err) => {
                    console.error(err);
                });
            }
        },
        draftsDeleteMail() {
            let deleteData = true;
            let drafts = true;
			this.selectedMailBox=[];
			checkboxes = document.querySelectorAll('input[name=mailbox]');
            [...checkboxes].map((el) => {
				if(el.checked){
					this.selectedMailBox.push(el.value)
				}
            })

            if (!isEmptyChack(this.selectedMailBox)) {
                const unreadResponse = doAjax(BASE_URL + 'in-mail/deletet-mail', 'post', {
                    ids: this.selectedMailBox, delete: deleteData, drafts:drafts, type: this.tab,qId:this.qId,vId:this.vId
                }, null, null, false).then((data) => {
                    this.selectedMailBox = [];
                   this.selectAll = false;

                    this.draftsMail();
                    $('input[name=mailbox],.allsekect').prop('checked', false);
                }).catch((err) => {
                    console.error(err);
                });
            }
        },
        importantMail(element = null) {
            let checked = 1;
            let refreshInbox = false;
            if (!isEmptyChack(element)) {
                let id = element.value;
                checked = element.checked ? 1 : 0;
                this.selectedMailBox.push(id);
            }
            else {
                refreshInbox = true
			    this.selectedMailBox=[];
                checkboxes = document.querySelectorAll('input[name=mailbox]');
                [...checkboxes].map((el) => {
                    if(el.checked){
                        this.selectedMailBox.push(el.value)
                    }
                })
			}
            if (!isEmptyChack(this.selectedMailBox)) {
               /*  console.log(this.selectedMailBox); */
                const unreadResponse = doAjax(BASE_URL + 'in-mail/important-mail', 'post', {
                    ids: this.selectedMailBox, important: checked, type: this.tab
                }, null, null, false).then((data) => {
					refreshInbox  && this.inboxMail();
                    this.selectedMailBox = [];
                    this.selectAll = false;
                    $('input[name=mailbox],.allsekect').prop('checked', false);
                    tab = 'inboxMail';
                }).catch((err) => {
                    console.error(err);
                });
               /*  this.sentMail(); */
            }
        },sentMail(){
            const sentResponse = doAjax(BASE_URL + 'in-mail/send-mail', 'post', {
                type: this.labels, _token: $('meta[name="csrf-token"]').attr('content'), page: this.page, search: this.search, role: this.labelUser,qId:this.qId,vId:this.vId
            }).then((response) => {
                if (response.status) {
                    if (response.status) {
                        $('.sentMailBox').html(response.view);
                        $('.footerHtml').html(response.footer);

                 }
                }
            }).catch((err) => {
                console.error(err);
            });
        },draftsMail(){
            const draftResponse = doAjax(BASE_URL + 'in-mail/draft-mail', 'post', {
                type: this.labels, _token: $('meta[name="csrf-token"]').attr('content'), page: this.page, search: this.search,qId:this.qId,vId:this.vId
            }).then((response) => {

                if (response.status) {
                     $('.draftsMailBox').html(response.view);
                  /*    if (!isEmptyChack(response?.footer)) { */
                         $('.footerHtml').html(response.footer);
                     /* } */
                 }
            }).catch((err) => {
                console.error(err);
            });
        }, inboxMail() {
            let isloader = isEmptyChack(this.search) ? true : false;
            const inboxResponse = doAjax(BASE_URL + 'in-mail/inbox-mail', 'post', {
                type: this.labels, _token: $('meta[name="csrf-token"]').attr('content'), page: this.page, search: this.search,role:this.labelUser,qId:this.qId,vId:this.vId
            }, null, null, isloader).then((response) => {
                 if (response.status) {
                     $('.inboxMailBox').html(response.view);
                     if (!isEmptyChack(response?.footer)) {
                         $('.footerHtml').html(response.footer);
                         var quill=$("#message-editor")[0].__quill;
                        var delta = quill.clipboard.convert('');
                        quill.setContents(delta, 'silent');
                     }
                 }

            }).catch((err) => {
                console.error(err);
            });
        },deleteMailList(){
            const inboxResponse = doAjax(BASE_URL + 'in-mail/inbox-mail', 'post', {
                type: this.labels, _token: $('meta[name="csrf-token"]').attr('content'), isDeleted: true, search: this.search, page: this.page, role: this.labelUser,qId:this.qId,vId:this.vId
            }).then((response) => {
                 if (response.status) {
                     $('.deleteMailBox').html(response.view);
                   /*   if (!isEmptyChack(response?.footer)) { */
                         $('.footerHtml').html(response.footer);
                    /*  } */
                 }

            }).catch((err) => {
                console.error(err);
            });
        }, mailDetails(id = this.mailId, type = this.typeButton) {

            this.typeButton = type;
            this.mailId = id;
            this.isdraftsMail = true;
           /*  console.log(this.mailId, type); */
            const details = doAjax(BASE_URL + 'in-mail/mail-details/'+id, 'post', {
                type: this.labels, type: type
            }).then((response) => {

				if(this.typeButton == 'drafts'){
					this.tab = 'newMail';
					let forM = $(".mailForm");
					if(forM.find('input[name="draftId"]').length >0){

					}else{
						forM.append(`<input type="hidden" name="draftId" value="${response.id}">`)
					}
					forM.find('input[name="draftId"]').val(response.data.id);
					forM.find('input[name="to"]').val(response.data.to_id);
					forM.find('input[name="cc"]').val(response.data.cc);
					forM.find('input[name="subject"]').val(response.data.subject);
					forM.find('input[name="message"]').val(response.data.message);
					$('#to').dropdown('setup menu', {values:response?.toHtml});
					$('#to').dropdown('set selected', response.data.to_id?.split(","));
					$('#cc').dropdown('setup menu', {values:response?.ccHtml});
					$('#cc').dropdown('set selected', response.data.cc?.split(","));
					var quill=$("#message-editor")[0].__quill;
					var delta = quill.clipboard.convert(response.data.message);
                    quill.setContents(delta, 'silent');
                    let imageHtml = " ",fileArrDarf=[];
                    if (!isEmptyChack(response?.data?.files)) {
                        const fileArr = response?.data?.files;

                        $.each(JSON.parse(fileArr), function (indexInArray, valueOfElement) {
                            fileArrDarf.push(valueOfElement.file_name);
                            imageHtml += `<div class="flow-progress media">
                                    <div class="media-body">
                                        <div><strong class="flow-file-name">${valueOfElement.original_name}</strong> <br> <em
                            class="flow-file-progress text-success">(file successfylly uploaded: )</em></div>

                                        </div>
                                    <div class="ml-3 align-self-center"><button type="button"
                                            class="flow-file-cancel btn btn-sm removeUploedFile"
                                            data-file-name="${valueOfElement.file_name}" data-id="" data-type="mail"><i class="fal fa-times-circle"></i></button>
                                            </div>
                                </div>`;
                        });
                       /*  $(".image_list_box").html('') */
                        $('.image_list_box').html(imageHtml);
                        if (!isEmptyChack(fileArrDarf)) {
                            forM.append(`<input type="hidden" class="attachments" name="attachments" value="${fileArrDarf}">`);
                        }
                    }
				}else{
					this.tab = 'mailDetailsBox';
					$('.mailDetailsBox').html(response);
					$('.footerHtml').html("");
					this.unreadMessageCount();
				}
            }).catch((err) => {
                console.error(err);
            });
        },resendMail() {
            let id = this.mailId;
            if (isEmptyChack(id)) {
                return false;
            }
            const details = doAjax(BASE_URL + 'in-mail/resend-mail/' + id, 'post', {
                type: this.labels,
            }).then((response) => {
                  successAlertModel(response.msg, response.url, 'url', 'single');

            }).catch((err) => {
                console.error(err);
            });

        }, replayMail(id = this.mailId) {
            $(".replayBox").html('');
            if (isEmptyChack(id)) {
                return false;
            }
            const details = doAjax(BASE_URL + 'in-mail/replay-mail/' + id, 'post', {
                type: this.labels,
            }).then((response) => {
                $(".replayBox").html(response)
				quillEditorFn(".replayBox .qEditor")
                this.tab = "replayBox";


            }).catch((err) => {
                console.error(err);
            });
        }, forwardMail(id = this.mailId) {
         /*    let id = this.mailId; */
            $(".replayBox").html('');
           const details = doAjax(BASE_URL + 'in-mail/replay-mail/' + id, 'post', {
               type: this.labels, replayType: 'forward'
           }).then((response) => {
               $(".replayBox").html(response)
               quillEditorFn(".replayBox .qEditor")
               this.tab = "replayBox";
                remotelyDropDown("#forwardto", 'common/mail-send-user')
                remotelyDropDown("#forwardcc", 'common/mail-send-user')

           }).catch((err) => {
               console.error(err);
           });

		}, replyMailSend() {
		    let id = this.mailId;
		    let forM = $(".replyMailBox");
            let isValid = isValidation(forM, notClass = true);
           /*  console.log(isValid); */
		    if (!isValid) {
		        return false;
		    }
		    let args = serializeFilter(forM);
		    let url = forM.attr("action");
		    let _method = forM.find(" input[name='_method']").val();
		    const replyRespnse = doAjax(url, _method, args)
		        .then((response) => {
		            if (response.status) {
                        successAlertModel(response.msg, response.url, 'url', 'single');
		            }
		        }).catch((err) => {
		            console.error(err);
		        });
        }, clearlabelUser() {
            this.labelUser = null;
        },
        slideEffect() {
            $('.footerHtml').html(null);
         /*    console.log(this.tab); */
            switch (this.tab) {
                case 'newMail':
                    console.log(this.isdraftsMail);
					if(this.isdraftsMail == false){
                        resrtForm('.mailForm')
                    }
                    remotelyDropDown("#to", 'common/mail-send-user', {
                        role: this.labelUser,
                        qId :this.qId

                    })
                    remotelyDropDown("#cc", 'common/mail-send-user', {
                        role: this.labelUser,
                        qId :this.qId
                    })
                    break;
                case 'sentMail':
                    $('.htmlData,.replyMailBox').html('');
                    this.sentMail();
                    this.isdraftsMail = false;
                    break;
                case 'draftsMail':
                    this.typeButton = null;
                     $('.htmlData,.replyMailBox').html('');
                    this.draftsMail();
                    break;
                case 'inboxMail':
                    this.isdraftsMail = false;
                    this.typeButton = null;
                     $('.htmlData,.replyMailBox').html('');
                    this.inboxMail();
                    break;
                /* case 'clearinboxMail':
                    this.tab = 'inboxMail';
                    this.typeButton = null;
                     $('.htmlData,.replyMailBox').html('');
                    this.inboxMail();
                    break; */
                case 'deleteMail':
                    this.isdraftsMail = false;
                     $('.htmlData,.replyMailBox').html('');
                    this.deleteMailList();
                    break;
                default:
                    break;
            }
        }

    }))
})

$(function () {
    /* user Dropdwon */


    $(document).on("click", '.sendMessage', async function (e) {
        let forM = $(".mailForm");
        let isValid = isValidation(forM, notClass = true);
        e.preventDefault();
        e.stopPropagation();
        if (isValid) {
            let formClass = forM;
            let args = await serializeFilter(forM);
            let url = await forM.attr("action");
            let _method = forM.find(" input[name='_method']").val();
            saveMessage(url, 'post', args, forM);

        }
    });
    $(document).on("click", '.saveMessage', async function (e) {
        let forM = $(".mailForm");
        let isValid = isValidation(forM, notClass = true);

        e.preventDefault();
        e.stopPropagation();
        if (isValid) {
            let formClass = forM;
            let args = await serializeFilter(forM);
            let url = await forM.attr("action");
            let _method = forM.find(" input[name='_method']").val();
            args.push({
                name: 'draft',
                value: true
            });
            saveMessage(url, 'post', args, forM);
        }
    });


    async function saveMessage(url, _method, args, forM, msg = true) {
      /*   console.log(args) */
        let data = await doAjax(url, _method, args, {
            dataType: "json",
        }, forM, msg);
        if (data.status) {
          /*   fileArray = []; */
        }
        if (data.status == true && msg == true) {
            if(!isEmptyChack(data.type)){
                //location.reload()
                successAlertModel(data.msg, data.action, "attr", "single",null,'.in_mail_box_section');
            }else{
                successAlertModel(data.msg, data.url, 'url', 'single',null,'.in_mail_box_section');
            }

        }
        return data;
    }


    $(document).on("change", '.mailForm input:not(".fileUpload"),.mailForm select', async function () {
        //Delay For image Upload Issue the use setTimeout function
      /*   setTimeout(async () => { */
            let forM = $(".mailForm");
            let args = await serializeFilter(forM);

            args.push({
                name: 'draft',
                value: true,
            });
            let url = await forM.attr("action");
            let _method = forM.find(" input[name='_method']").val();
                const response = await saveMessage(url, 'post', args, forM, msg = false);
                forM.find('input[name="draftId"]').remove();
                forM.append(`<input type="hidden" name="draftId" value="${response.id}">`)
        /*  }, 1000); */
    });



});
