<?php

namespace App\Http\Controllers;

use App\Repositories\BiogMainRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasicInformationKinshipController extends Controller
{
    /**
     * @var BiogMainRepository
     */
    protected $biogMainRepository;

    /**
     * TextsController constructor.
     * @param BiogMainRepository $biogMainRepository
     */
    public function __construct(BiogMainRepository $biogMainRepository)
    {
        $this->biogMainRepository = $biogMainRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $biogbasicinformation = $this->biogMainRepository->byIdWithKinship($id);
        return view('biogmains.kinship.index', ['basicinformation' => $biogbasicinformation,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 親屬']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('biogmains.kinship.create', [
            'id' => $id,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 親屬', 'page_url' => '/basicinformation/'.$id.'/kinship']);
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
        $_id = $this->biogMainRepository->kinshipStoreById($request, $id);
        flash('Store success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.kinship.edit', ['id' => $id, '_id' => $_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $id_)
    {
        $res = $this->biogMainRepository->kinshipById($id_);
//        dd($res);
        return view('biogmains.kinship.edit', ['id' => $id, 'row' => $res['row'], 'res' => $res,
            'page_title' => 'Basicinformation', 'page_description' => '基本信息表 親屬',
            'page_url' => '/basicinformation/'.$id.'/kinship',
            'archer' => "<li><a href='#'>Kinship</a></li>",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_)
    {
        if (!Auth::check()) {
            flash('请登入后编辑 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        elseif (Auth::user()->is_active != 1){
            flash('该用户没有权限，请联系管理员 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        $this->biogMainRepository->kinshipUpdateById($request, $id, $id_);
        flash('Update success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.kinship.edit', ['id'=>$id, 'id_'=>$id_]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_)
    {
        if (!Auth::check()) {
            flash('请登入后编辑 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        elseif (Auth::user()->is_active != 1){
            flash('该用户没有权限，请联系管理员 @ '.Carbon::now(), 'error');
            return redirect()->back();
        }
        $this->biogMainRepository->kinshipDeleteById($id_, $id);
        flash('Delete success @ '.Carbon::now(), 'success');
        return redirect()->route('basicinformation.kinship.index', ['id' => $id]);
    }
}
