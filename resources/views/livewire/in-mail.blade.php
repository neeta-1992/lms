<div>
 <section class="font-1 pt-5 hq-full" x-data="{tab:'newMail'}">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ $pageTitle ?? '' }}
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <div class="col-md-12 page_table_menu">
                    <div class="row ">
                        <div class="col-md-12" x-show="(open != 'offices' && open != 'users' && open != 'logs')">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        <button class="btn btn-default sendMessage" wire:click="sendMessage" type="button">@lang('labels.send')</button>
                                        <button class="btn btn-default saveMessage" type="button">@lang('labels.save')</button>
                                        <button class="btn btn-default" type="button"><a
                                                href="{{ routeCheck($route . 'index') }}"
                                                data-turbolinks="false">@lang('labels.cancel')</a></button>
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
                                    <li><a href="javascript:void(0)" x-on:click="tab = 'newMail'"><i class="fa-thin fa-plus"></i> &nbsp; New InMail</a></li>
                                    <li><a href="javascript:void(0)" x-on:click="tab = 'inboxMail'"><i class="fa-thin fa-inboxes"></i> &nbsp; Inbox</a></li>
                                    <li><a href="javascript:void(0)" x-on:click="tab = 'draftsMail'"><i class="fa-thin fa-pen"></i> &nbsp; Drafts</a></li>
                                    <li><a href="javascript:void(0)" x-on:click="tab = 'deleteMail'"><i class="fa-thin fa-trash-can"></i> &nbsp; Delete</a></li>
                                </ul>
                                <hr class="border-light m-4">
                                <div class="font-weight-bold px-4 d-inline">LABELS <span style="display:none;"
                                        class="cursorcss refreshlables ml-2"><i class="fa-thin fa-arrows-rotate messages-tooltip"title="Clear labels"></i></span></div>
                            <a href="javascript:void(0)" class="d-block text-muted py-1 px-4 usertype"
                                    data-role="finance_companine" data-type="1">
                                    <span class="badge badge-success">Finance Companies</span>
                                    <span class="badge badge-dot badge-success mr-1 dotshow"
                                        style="display:none;"></span>
                                </a>
                                    </div>
                        </div>
                        <div class="inmail_tab_content">
                            <div class="inmail_tab_content_inner" x-show="tab == 'newMail'">
                                <x-form method="post" class="mailForm" action="{{ routeCheck($route.'store') }}">
                                    <div class="form-group">
                                        <label for="to" class="requiredAsterisk">@lang('labels.to')</label>
                                        <x-select wire:model.defer="to[]" class="userDropdown" placeholder="Select To" multiple  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc" >@lang('labels.cc')</label>
                                        <x-select wire:model.defer="cc[]" class="userDropdown" placeholder="Select To" multiple  />
                                    </div>
                                    <div class="form-group" >
                                        <label for="subject" class="requiredAsterisk">@lang('labels.subject')</label>
                                        <x-jet-input type="text" wire:model.defer="subject" placeholder="Subject" data-meteor-emoji="true" required/>

                                    </div>
                                    <div class="form-group">
                                        <label for="to">@lang('labels.message')</label>
                                        <x-quill-editor  style="height: 350px" id="message" wire:model.defer="message" data-name="message" required/>
                                    </div>
                                </x-form>
                            </div>
                            <div class="inmail_tab_content_inner" x-show="tab == 'inboxMail'">

                                inbox
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
