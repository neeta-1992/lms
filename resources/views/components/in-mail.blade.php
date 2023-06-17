<div class="in_mail_box_section w-100" x-data="mailBox" x-effect="slideEffect">
    <div class="col-md-12 page_table_menu">
        <div class="row ">
            <div class="col-md-12">
                <div class="row align-items-end loadhideContent d-none">
                    <div class="col-md-12">
                        <div class="columns d-flex justify-content-end ">
                            <div x-show="tab == 'newMail'">
                                <button class="btn btn-default sendMessage" type="button">@lang('labels.send')</button>
                                <button class="btn btn-default saveMessage" type="button">@lang('labels.save')</button>
                            </div>
                            <div x-show="tab == 'inboxMail'" :class="tab == 'inboxMail' ? 'd-flex' : ''">
                                <div>
                                    <input type="search" x-model.throttle.500ms="search" />
                                </div>
                                <button class="btn btn-default" x-on:click="refreshMail()" type="button">@lang('labels.refresh')</button>
                                <button class="btn btn-default" x-on:click="unreadMail()" type="button">@lang('labels.unread')</button>
                                <button class="btn btn-default " x-on:click="importantMail()" type="button">@lang('labels.important')</button>
                                <button class="btn btn-default" x-on:click="deleteMail()" type="button">@lang('labels.delete')</button>
                            </div>
                            <div x-show="(typeButton == 'inbox' && tab !== 'replayBox')" :class="(typeButton == 'inbox'  && tab !== 'replayBox') ? 'd-flex' : ''">
                                <button class="btn btn-default" x-on:click="replayMail()" type="button">@lang('labels.replay')</button>
                                <button class="btn btn-default" x-on:click="forwardMail()" type="button">@lang('labels.forward')</button>
                                <button class="btn btn-default" x-on:click="unreadMail()" type="button">@lang('labels.unread')</button>
                                <button class="btn btn-default " x-on:click="importantMail()" type="button">@lang('labels.important')</button>
                                <button class="btn btn-default" x-on:click="deleteMail()" type="button">@lang('labels.delete')</button>
                            </div>
                            <div x-show="(tab == 'replayBox')">
                                <button class="btn btn-default" x-on:click="mailDetails()" type="button">@lang('labels.back')</button>
                                <button class="btn btn-default" type="button" x-on:click="replyMailSend()">@lang('labels.send')</button>
                            </div>
                            <div x-show="tab == 'draftsMail'">
                                <button class="btn btn-default" x-on:click="draftsDeleteMail()" type="button">@lang('labels.delete')</button>
                            </div>
                            <button class="btn btn-default" type="button" x-show="typeButton == 'sent'" x-on:click="resendMail()">Resend email</button>
                            @if(!empty($cancel))
                            <button class="btn btn-default" type="button"><a href="javascript:void(0)" data-turbolinks="false" x-on:click="open = '{{ $cancel ?? '' }}'">@lang('labels.cancel')</a></button>
                            @else
                            <button class="btn btn-default" type="button"><a href="{{ routeCheck(" company.dashboard")
                                    }}" data-turbolinks="false">@lang('labels.cancel')</a></button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="page-content col-md-12">
        <div class="inmail_tabs_box ">
            <div class="inmail_sidebar">
                <div class="inmail_sidebar_inner">
                    <ul style="list-style: none;">
                        @empty($qdelete)
                        <li><a href="javascript:void(0)" x-on:click="tab = 'newMail'" :class="tab == 'newMail' ? 'active' : ''">New InMail</a></li>
                        @endempty
                        <li><a href="javascript:void(0)" x-on:click="tab = 'inboxMail'" :class="tab == 'inboxMail' ? 'active' : ''">Inbox <div class="badge badge-primary" style="font-size: 10px;" x-text="unreadMailInbox"></div></a> </li>
                        <li><a href="javascript:void(0)" x-on:click="tab = 'sentMail'" :class="tab == 'sentMail' ? 'active' : ''">Sent Items</a></li>
                        @empty($qdelete)
                        <li><a href="javascript:void(0)" x-on:click="tab = 'draftsMail'" :class="tab == 'draftsMail' ? 'active' : ''">Drafts</a></li>
                        @endempty
                        <li><a href="javascript:void(0)" x-on:click="tab = 'deleteMail'" :class="tab == 'deleteMail' ? 'active' : ''">Deleted Items</a></li>
                    </ul>
                    <hr class="border-light m-4">
                    <div class="font-weight-bold px-4 d-inline">LABELS <span x-show="labelUser != null" class="cursorcss refreshlables ml-2" @click="labelUser = null"><i class="fa-thin fa-arrows-rotate messages-tooltip" title="Clear labels"></i></span>
                    </div>
                    @can('isAdminCompany')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'finance_companies' ? null : 'finance_companies')" class="d-block text-muted py-1 px-4 "><span class="badge badge-success">@lang("labels.finance_companies")</span>
                        <button type="button" class="btn btn-success btn-circle btn-xsm" x-show="labelUser == 'finance_companies'"></button>

                    </a>
                    @if(!empty($type) && $type == 'quote')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'insureds' ? null : 'insureds')" class="d-block text-muted py-1 px-4 "><span class="badge badge-danger">@lang("labels.insureds")</span>
                        <button type="button" class="btn btn-danger btn-circle btn-xsm" x-show="labelUser == 'insureds'"></button>

                    </a>
                    @endif
                    @else

                    @endcan
                    @can('companyAdmin')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'lms_support' ? null : 'lms_support')" class="d-block text-muted py-1 px-4">
                        <span class="badge badge-dark">@lang("labels.lms_support")</span>
                        <button type="button" class="btn btn-dark btn-circle btn-xsm" x-show="labelUser == 'lms_support'"></button>
                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'finance_companies' ? null : 'finance_companies')" class="d-block text-muted py-1 px-4 "><span class="badge badge-success">@lang("labels.finance_companies")</span>
                        <button type="button" class="btn btn-success btn-circle btn-xsm" x-show="labelUser == 'finance_companies'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'insureds' ? null : 'insureds')" class="d-block text-muted py-1 px-4 "><span class="badge badge-danger">@lang("labels.insureds")</span>
                        <button type="button" class="btn btn-danger btn-circle btn-xsm" x-show="labelUser == 'insureds'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'sales_organizations' ? null : 'sales_organizations')" class="d-block text-muted py-1 px-4">
                        <span class="badge badge-warning">@lang("labels.sales_organizations")</span>
                        <button type="button" class="btn btn-warning btn-circle btn-xsm" x-show="labelUser == 'sales_organizations'"></button>
                    </a>
                    @endcan
                    @can('companyUser')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'finance_companies' ? null : 'finance_companies')" class="d-block text-muted py-1 px-4 "><span class="badge badge-success">@lang("labels.finance_companies")</span>
                        <button type="button" class="btn btn-success btn-circle btn-xsm" x-show="labelUser == 'finance_companies'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'insureds' ? null : 'insureds')" class="d-block text-muted py-1 px-4 "><span class="badge badge-danger">@lang("labels.insureds")</span>
                        <button type="button" class="btn btn-danger btn-circle btn-xsm" x-show="labelUser == 'insureds'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'sales_organizations' ? null : 'sales_organizations')" class="d-block text-muted py-1 px-4">
                        <span class="badge badge-warning">@lang("labels.sales_organizations")</span>
                        <button type="button" class="btn btn-warning btn-circle btn-xsm" x-show="labelUser == 'sales_organizations'"></button>

                    </a>
                    @endcan
                    @can('agentUser')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'finance_companies' ? null : 'finance_companies')" class="d-block text-muted py-1 px-4 "><span class="badge badge-success">@lang("labels.finance_companies")</span>
                        <button type="button" class="btn btn-success btn-circle btn-xsm" x-show="labelUser == 'finance_companies'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'insureds' ? null : 'insureds')" class="d-block text-muted py-1 px-4 "><span class="badge badge-danger">@lang("labels.insureds")</span>
                        <button type="button" class="btn btn-danger btn-circle btn-xsm" x-show="labelUser == 'insureds'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'sales_organizations' ? null : 'sales_organizations')" class="d-block text-muted py-1 px-4">
                        <span class="badge badge-warning">@lang("labels.sales_organizations")</span>
                        <button type="button" class="btn btn-warning btn-circle btn-xsm" x-show="labelUser == 'sales_organizations'"></button>
                    </a>
                    @endcan
                    @can('insuredUser')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'insureds' ? null : 'insureds')" class="d-block text-muted py-1 px-4 "><span class="badge badge-danger">@lang("labels.insureds")</span>
                        <button type="button" class="btn btn-danger btn-circle btn-xsm" x-show="labelUser == 'insureds'"></button>

                    </a>

                    @endcan
                    @can('saleorgUser')
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'finance_companies' ? null : 'finance_companies')" class="d-block text-muted py-1 px-4 "><span class="badge badge-success">@lang("labels.finance_companies")</span>
                        <button type="button" class="btn btn-success btn-circle btn-xsm" x-show="labelUser == 'finance_companies'"></button>

                    </a>
                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'agents' ? null : 'agents')" class="d-block text-muted py-1 px-4 ">
                        <span class="badge badge-info">@lang("labels.agents")</span>
                        <button type="button" class="btn btn-info btn-circle btn-xsm" x-show="labelUser == 'agents'"></button>

                    </a>

                    <a href="javascript:void(0)" x-on:click="labelUser = (labelUser === 'sales_organizations' ? null : 'sales_organizations')" class="d-block text-muted py-1 px-4">
                        <span class="badge badge-warning">@lang("labels.sales_organizations")</span>
                        <button type="button" class="btn btn-warning btn-circle btn-xsm" x-show="labelUser == 'sales_organizations'"></button>
                    </a>

                    @endcan




                </div>
            </div>

            <div class="inmail_tab_content">
                <div class="inmail_tab_content_inner loadhideContent" x-show="tab == 'inboxMail'">
                    <div class="inmail_tab_heading">
                        <div class="inmail_tab_heading_check">
                            <x-jet-checkbox for="inboxMail" x-bind:checked="selectAll" id="inboxMail" labelText='' class="allsekect permissionCheckBox" x-on:click="toggleAllCheckboxes()" />
                        </div>
                        <div class="inmail_tab_heading_form">
                            {{ __('labels.from') }}
                        </div>
                        <div class="inmail_tab_heading_subject">
                            {{ __('labels.subject') }}
                        </div>
                        <div class="inmail_tab_heading_date">
                            {{ __('labels.date_and_time') }}
                        </div>
                    </div>
                    <div class="inboxMailBox htmlData">

                    </div>
                </div>
                <div class="inmail_tab_content_inner " x-show="tab == 'newMail'">
                    <div class="inmail_form">
                        <x-form method="post" class="mailForm" action="{{ routeCheck($route . 'store') }}">
                            <x-jet-input type="hidden" name="qid" class="qId" value="" />
                            <x-jet-input type="hidden" name="vid" class="vId" value="" />
                            <x-jet-input type="hidden" name="version" class="version" value="" />
                            <div class="form-group">
                                <label for="to" class="requiredAsterisk">@lang('labels.to')</label>
                                <x-semantic-dropdown class="userDropdown multiple" name="to" required="required" id="to" />

                            </div>
                            <div class="form-group">
                                <label for="cc">@lang('labels.cc')</label>
                                <x-semantic-dropdown class="userDropdown multiple" name="cc" id="cc" />
                            </div>
                            <input type="hidden" name="quote_subject" class="quote_subject" value="" />
                            <div class="form-group subject_emoji_input">
                                <label for="subject" class="requiredAsterisk">@lang('labels.subject')</label>
                                <div class="input-group mb-3 input-group-sm quoteIdSubject d-none">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text "></span>
                                    </div>
                                </div>
                                <x-jet-input type="text" name="subject" placeholder="Subject" data-meteor-emoji="true" required />

                            </div>
                            <div class="form-group">
                                <label for="to" class="requiredAsterisk">@lang('labels.message')</label>
                                <x-quill-editor style="height: 350px" id="message" name="message" data-name="message" required />
                            </div>
                        </x-form>
                    </div>
                </div>
                <div class="inmail_tab_content_inner" x-show="tab == 'sentMail'">
                    <div class="inmail_tab_heading">
                        <div class="inmail_tab_heading_check">
                            <x-jet-checkbox for="inboxMail" x-bind:checked="selectAll" id="inboxMail" labelText='' class="allsekect permissionCheckBox" x-on:click="toggleAllCheckboxes()" />
                        </div>
                        <div class="inmail_tab_heading_form">
                            {{ __('labels.to') }}
                        </div>
                        <div class="inmail_tab_heading_subject">
                            {{ __('labels.subject') }}
                        </div>
                        <div class="inmail_tab_heading_date">
                            {{ __('labels.date_and_time') }}
                        </div>
                    </div>
                    <div class="sentMailBox htmlData">

                    </div>
                </div>
                <div class="inmail_tab_content_inner" x-show="tab == 'draftsMail'">
                    <div class="inmail_tab_heading">
                        <div class="inmail_tab_heading_check">
                            <x-jet-checkbox for="inboxMail" x-bind:checked="selectAll" id="inboxMail" labelText='' class="allsekect permissionCheckBox" x-on:click="toggleAllCheckboxes()" />
                        </div>
                        <div class="inmail_tab_heading_form">
                            {{ __('labels.to') }}
                        </div>
                        <div class="inmail_tab_heading_subject">
                            {{ __('labels.subject') }}
                        </div>
                        <div class="inmail_tab_heading_date">
                            {{ __('labels.date_and_time') }}
                        </div>
                    </div>
                    <div class="draftsMailBox htmlData">

                    </div>
                </div>
                <div class="inmail_tab_content_inner" x-show="tab == 'deleteMail'">
                    <div class="inmail_tab_heading">
                        <div class="inmail_tab_heading_check">
                            <x-jet-checkbox for="deleteMail" x-bind:checked="selectAll" id="deleteMail" labelText='' class="allsekect permissionCheckBox" x-on:click="toggleAllCheckboxes()" />
                        </div>
                        <div class="inmail_tab_heading_form">
                            {{ __('labels.to') }}
                        </div>
                        <div class="inmail_tab_heading_subject">
                            {{ __('labels.subject') }}
                        </div>
                        <div class="inmail_tab_heading_date">
                            {{ __('labels.date_and_time') }}
                        </div>
                    </div>
                    <div class="deleteMailBox htmlData">

                    </div>
                </div>
                <div class="inmail_tab_content_inner" x-show="tab == 'mailDetailsBox'">
                    <div class="inmail_tab_heading">
                        <div class="inmail_tab_heading_form" x-text="((typeButton == 'inbox') ? '{{ __('labels.from') }}' : '{{ __('labels.to') }}')">
                        </div>

                        <div class="inmail_tab_heading_subject">
                            {{ __('labels.subject') }}
                        </div>
                        <div class="inmail_tab_heading_date">
                            {{ __('labels.date_and_time') }}
                        </div>
                    </div>
                    <div class="mailDetailsBox htmlData mt-3">

                    </div>
                </div>
                <div class="inmail_tab_content_inner replayBox" x-show="tab == 'replayBox'">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 footerHtml">

    </div>
</div>
