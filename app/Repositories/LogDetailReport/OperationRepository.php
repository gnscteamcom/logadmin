<?php
/**
 * Created by PhpStorm.
 * User: hanjinhu
 * Date: 2019/11/01
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
        $this->collection = 'wuba_log_list';
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