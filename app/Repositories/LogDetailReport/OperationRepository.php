<?php
/**
 * Created by PhpStorm.
 * User: WangYe
 * Date: 2018/10/09
 */

namespace App\Repositories\LogDetailReport;

use Illuminate\Support\Facades\DB;



class OperationRepository
{
    private $dbObj;
    private $collection;

    public function __construct()
    {
   		$this->dbObj = DB::connection('mongodb_log');
        $this->collection = 'leju_log_list';
    }

	
	
    public function getOperationLogData($dateSuffix,$where)
    {
        $collection = $this->collection.'_'.$dateSuffix;
        return  $this->dbObj
                ->collection($collection)
                ->where($where)
                ->paginate(10);
    }
}