<x-app-layout>
    @php
        $title = "Agents Assigned to {$data['name']} Rate Table";
    @endphp
    <x-jet-form-section :buttonGroup="['other' => [['text' => 'Cancel', 'url' => routeCheck($route . 'edit', $id)]]]" :title="$title" class="" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">
        @slot('form')

            <div class="mb-3">
                <p class="">To search for agents that you want to assign to <b>{{ $data['name'] ?? '' }}</b> table,
                    enter your criteria below and press the <b>Find</b> button. Leave all fields blank to browse all
                    available
                    (unassigned) agents.</p>
            </div>
           <div class="serchForm">


            <div class="form-group row">
                <label for="comp_name" class="col-sm-3 col-form-label ">Search</label>
                <div class="col-sm-9">
                    <input type="text" name="search" class="form-control input-sm" id="search"
                        placeholder="Search by agency name, agent, city, state, zip">
                </div>
            </div>
            <div class="row form-group">
                <label for="" class="col-sm-3 col-form-label "></label>
                <div class="col-sm-9">
                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                        <input class="" name="status[]" type="checkbox" id="open_status" value="1">
                        <label class=" " for="open_status">All</label>
                    </div>
                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                        <input class="" name="status[]" type="checkbox" id="locked_status" value="2">
                        <label class="" for="locked_status">Agents with Active Accounts</label>
                    </div>
                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                        <input class="" name="status[]" type="checkbox" id="draft_status" value="3">
                        <label class="" for="draft_status">Agents with Open Quotes</label>
                    </div>
                    <div class="zinput zcheckbox zcheckbox-sm zinput-inline p-0">
                        <input class="" name="status[]" type="checkbox" id="all_activation_status" value="4">
                        <label class="" for="all_activation_status">Assigned Agents</label>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="esignature" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <button type="button" class="button-loading btn btn-primary searchAgent">
                        <span class="button--loading d-none"></span> <span class="button__text">Search</span>
                    </button>
                    <button type="button" class="btn btn-secondary backUrl">
                        Cancel
                    </button>
                </div>
            </div>
            </div>
            <div class="agentTable d-none">
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="['cookieid' => true,'type' => 'serverside','id'=>'agents_assigned_table']" :otherButton="[['text'=>'Remove Selected Agents','actiontype'=>'click','status'=>true],['text'=>'Add Agent','actiontype'=>'click','status'=>true]]">
                    <thead>
                        <tr>
                            <th class=""></th>
                            <th class="" data-sortable="true" data-field="created_at">Agency Name</th>
                            <th class="" data-sortable="true" data-field="created_at">Contact</th>
                            <th class="align-middle" data-sortable="true"  data-field="name">City</th>
                            <th class="align-middle" data-sortable="true" data-field="state">State</th>
                            <th class="align-middle" data-sortable="true" data-field="zip">Zip</th>
                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
            </div>
        @endslot


    </x-jet-form-section>
</x-app-layout>
