<?php
/**
 * Created by PhpStorm.
 * User: fuqunchao
 * Date: 2017/8/30
 * Time: 14:43
 */

namespace App\Repositories;


use App\AddressCode;
use Illuminate\Http\Request;

/**
 * Class AddrCodeRepository
 * @package App\Repositories
 */
class AddrCodeRepository
{

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return AddressCode::paginate(200);
    }

    /**
     * @param $request
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function addrByQuery(Request $request, $num=20)
    {
        if ($temp = $request->num){
            $num = $temp;
        }
        if (!$request->q){
            return AddressCode::select(['c_addr_id', 'c_name_chn', 'c_name'])->paginate($num);
        }
        $names = AddressCode::select(['c_addr_id', 'c_name_chn', 'c_name'])->where('c_name_chn', 'like', '%'.$request->q.'%')->orWhere('c_name', 'like', '%'.$request->q.'%')->orWhere('c_addr_id', $request->q)->paginate($num);
        $names->appends(['q' => $request->q])->links();
        return $names;
    }

    public function byId($id)
    {
        return AddressCode::find($id);
    }

    public function updateById($request, $id)
    {
        $data = $request->all();
        $addrcode = AddressCode::find($id);
        $addrcode->update($data);
    }

    public function searchAddr(Request $request)
    {
        $data = AddressCode::select(['c_addr_id', 'c_name_chn', 'c_name'])->where('c_name_chn', 'like', '%'.$request->q.'%')->orWhere('c_name', 'like', '%'.$request->q.'%')->orWhere('c_addr_id', $request->q)->paginate(20);
        $data->appends(['q' => $request->q])->links();
        foreach($data as $item){
            $item['id'] = $item->c_addr_id;
            if($item['id'] === 0) $item['id'] = -999;
            $item['text'] = $item->c_addr_id." ".$item->c_name." ".$item->c_name_chn;
        }
        return $data;
    }
    public function searchOfficeAddr(Request $request)
    {
        $data = AddressCode::select(['c_addr_id', 'c_name_chn', 'c_name'])->where('c_name_chn', 'like', '%'.$request->q.'%')->orWhere('c_name', 'like', '%'.$request->q.'%')->orWhere('c_addr_id', $request->q)->paginate(20);
        $data->appends(['q' => $request->q])->links();
        foreach($data as $item){
            $item['id'] = $item->c_addr_id == 0 ? -999 : $item->c_addr_id;
            $item['text'] = $item->c_addr_id." ".$item->c_name." ".$item->c_name_chn;
        }
        return $data;
    }
}