<?php
namespace App\Services;
use Exception;
use App\Models\Thread;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ThreadRequest;

class ThreadService
{
    /**
     * Create new thread and first new message.
     *
     * @param array $data
     * @return Tread $thread
     */
    public function createThread(ThreadRequest $request)
    {
       $thread = new Thread();
       $thread->title = $request->thread_title;
       $thread->user_id = Auth::id();
       $thread->is_user_checked = true;
       $thread->latest_comment_time = Carbon::now();            
            
       $message = new Message();
       $message->body = $request->contents;
       $message->user_id = Auth::id();

        DB::beginTransaction();
        try {
            $thread->save();
            $message->thread_id = $thread->id;
            $message->save();
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();
        return $thread;
    }
}