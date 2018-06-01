<?php

namespace App\Http\Controllers;

use App\AddressCode;
use App\Repositories\BiogMainRepository;
use App\Repositories\OperationRepository;
use App\Repositories\ToolsRepository;
use App\TextCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasicInformationAddressesController extends Controller
{
    /**
     * @var BiogMainRepository
     */
    protected $biogMainRepository;
    protected $operationRepository;
    protected $toolsRepository;

    /**
     * TextsController constructor.
     * @param BiogMainRepository $biogMainRepository
     */
    public function __construct(BiogMainRepository $biogMainRepository,OperationRepository $operationRepository, ToolsRepository $toolsRepository)
    {
        $this->middleware('auth');
        $this->biogMainRepository = $biogMainRepository;
        $this->operationRepository = $operationRepository;
        $this->toolsRepository = $toolsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $biogbasicinformation = $this->biogMainRepository->byIdWithAddr($id);
        return view('biogmains.addresses.index', ['basicinformation' => $biogbasicinformation,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 地址']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('biogmains.addresses.create', [
            'id' => $id,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 地址', 'page_url' => '/basicinformation/'.$id.'/addresses']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (!Auth::check()) {
            flash('请登入后编辑 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        elseif (Auth::user()->is_active != 1){
            flash('该用户没有权限，请联系管理员 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        $data['c_addr'] = 0;
        $data = $request->all();
        $data = array_except($data, ['_token']);
        $data['c_personid'] = $id;
        $data['c_fy_intercalary'] = (int)($data['c_fy_intercalary']);
        $data['c_ly_intercalary'] = (int)($data['c_ly_intercalary']);
        $data['tts_sysno'] = DB::table('BIOG_ADDR_DATA')->max('tts_sysno') + 1;
//        dd($data);
        $data = $this->toolsRepository->timestamp($data, True);
        DB::table('BIOG_ADDR_DATA')->insert($data);
        $this->operationRepository->store(Auth::id(), $id, 1, 'BIOG_ADDR_DATA', $data['tts_sysno'], $data);
        flash('Store success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.addresses.edit', ['id' => $id, 'addr' => $data['tts_sysno']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $addr)
    {
//        dd($id.' '.$addr);
        $row = DB::table('BIOG_ADDR_DATA')->where('tts_sysno', $addr)->first();
        $addr_str = null;
        if($row->c_addr_id || $row->c_addr_id === 0){
            $addr_ = AddressCode::find($row->c_addr_id);
            $addr_str = $addr_->c_addr_id." ".$addr_->c_name." ".$addr_->c_name_chn;
        }
        $text_str = null;
//        dd($row->c_source);
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }

        return view('biogmains.addresses.edit', ['id' => $id, 'row' => $row, 'addr_str' => $addr_str, 'text_str' => $text_str,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 地址',
            'page_url' => '/basicinformation/'.$id.'/addresses',
            'archer' => "<li><a href='#'>Address</a></li>",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $addr)
    {
        if (!Auth::check()) {
            flash('请登入后编辑 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        elseif (Auth::user()->is_active != 1){
            flash('该用户没有权限，请联系管理员 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        $data = $request->all();

        $data['c_fy_intercalary'] = (int)($data['c_fy_intercalary']);
        $data['c_ly_intercalary'] = (int)($data['c_ly_intercalary']);

        $data = array_except($data, ['_method', '_token']);
        $data = $this->toolsRepository->timestamp($data);
        DB::table('BIOG_ADDR_DATA')->where('tts_sysno',$addr)->update($data);
//        dd(DB::table('BIOG_ADDR_DATA')->where('tts_sysno',$id)->first());
        $this->operationRepository->store(Auth::id(), $id, 3, 'BIOG_ADDR_DATA', $addr, $data);
        flash('Update success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.addresses.edit', ['id'=>$id, 'addr'=>$addr]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $addr)
    {
        if (!Auth::check()) {
            flash('请登入后编辑 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        elseif (Auth::user()->is_active != 1){
            flash('该用户没有权限，请联系管理员 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
//        dd($id.' '.$addr);
        $row = DB::table('BIOG_ADDR_DATA')->where('tts_sysno', $addr)->first();

        DB::table('BIOG_ADDR_DATA')->where('tts_sysno', $addr)->delete();
        $this->operationRepository->store(Auth::id(), $id, 4, 'BIOG_ADDR_DATA', $addr, $row);
        flash('Delete success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.addresses.index', ['id' => $id]);
    }
}