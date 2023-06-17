<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Logs,MetaTag
};
use Str;
class LogsController extends Controller
{


    public  $pageTitle = "Logs";
    public function __construct(Logs $model){
        $this->model =  $model;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logs(Request $request,string $type="null",$id="")
    {

        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $did             = !empty($id) ? decryptUrl($id) : null ;

        $sqlData         = $this->model::whereType($type);
        if(!empty($did)){
            $sqlData = $sqlData->where('type_id',$did);
        }
        $totalCount      = $sqlData->count();
        $dataArr         = [];
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

          if(!empty($data)){
                foreach($data as $row){
                    $id = encryptUrl($row->id);
                    if(!empty($row->old_value) && !empty($row->new_value)){
                        $msg = Str::replace("{LOGSID}",$id,$row->message);
                    }else{
                        $msg = $row->message;
                    }
                    $dataArr[] = array(
                        "created_at" => changeDateFormat($row['created_at']),
                        "username"   => "System",
                        "message" => $msg,
                    );
                }
          }
          $response = array("total" =>$totalCount,"totalNotFiltered" =>$totalCount,"rows" => $dataArr);
          return json_encode($response);
    }


   /*
      Logs Details
    */
    public function logsDetails($id){
        $data = $this->model->decrypt($id)->first()?->toArray();
        $type = !empty($data['type']) ? $data['type'] : '' ;
        $old_value = !empty($data['old_value']) ? $data['old_value'] : '' ;
        $new_value = !empty($data['new_value']) ? $data['new_value'] : '' ;
        $response['new_value'] = $new_value;
        $response['old_value'] = $old_value;
        if(!empty($old_value) && !empty($new_value)){
            $response['css'] = MetaTag::getData(['key'=>'css','type'=> $type])->first()?->value;
        }
        return $response;
    }
}
