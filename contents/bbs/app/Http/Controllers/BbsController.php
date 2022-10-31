<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Message;
use App\Services\ThreadService;
use App\Http\Requests\ThreadRequest;

class ThreadController extends Controller
{
    /**
     * @var threadService
     */
    protected $thread_service;

    /**
     * Create a new controller instance.
     *
     * @param  ThreadService  $thread_service
     * @return void
     */
    public function __construct(
        ThreadService $thread_service // インジェクション
    ) {
        $this->middleware('auth')->except('index');
        $this->thread_service = $thread_service; // プロパティに代入する。
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // スレッド情報を取得して代入
       $threads = Thread::orderBy('created_at', 'desc')->get();
       // 掲示板ページを表示
       return view('bbs/index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ThreadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        try {
            $this->thread_service->createThread($request);
        } catch (Exception $error) {
            return redirect()->route('threads.index')->with('error', 'スレッドの新規作成に失敗しました。');
        }
        // redirect to index method
        return redirect()->route('threads.index')->with('success', 'スレッドの新規作成が完了しました。');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // スレッド情報をデータベースから削除
       $thread = Thread::find($id)->delete();
       return redirect('/bbs');
    }
}
