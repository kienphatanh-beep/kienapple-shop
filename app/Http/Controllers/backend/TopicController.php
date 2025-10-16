<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;

class TopicController extends Controller
{
/*index---------------------------------------------------------*/
    public function index()
    {
        $list = Topic::select('id', 'name', 'slug', 'description', 'status')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('backend.topic.index', compact('list'));
    }

    

/*create---------------------------------------------------------*/
    public function create()
    {
        return view('backend.topic.create');
    }

/*store---------------------------------------------------------*/
    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic();
        $topic->name = $request->name;
        $topic->slug = $request->slug ?: Str::slug($request->name);
        $topic->description = $request->description;
        $topic->created_by = Auth::id() ?? 1;
        $topic->status = $request->status ?? 1;
        $topic->save();

        return redirect()->route('topic.index')->with('success', 'Thêm chủ đề thành công!');
    }

/*show---------------------------------------------------------*/
public function show(string $id)
{
    $topic = Topic::find($id);
    if (!$topic) {
        return redirect()->route('topic.index')->with('error', 'Không tìm thấy chủ đề');
    }
    return view('backend.topic.show', compact('topic'));
}

/*edit---------------------------------------------------------*/
    public function edit(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return redirect()->route('topic.index')->with('error', 'Không tìm thấy chủ đề');
        }
        return view('backend.topic.edit', compact('topic'));
    }

   /*update---------------------------------------------------------*/
public function update(UpdateTopicRequest $request, string $id)
{
    $topic = Topic::find($id);
    if ($topic == null) {
        return redirect()->route('topic.index');
    }

    $topic->name = $request->name;
    $topic->slug = $request->slug ?: Str::slug($request->name);
    $topic->description = $request->description; // ✅ Thêm dòng này
    $topic->status = $request->status;
    $topic->updated_by = Auth::id() ?? 1;
    $topic->updated_at = now();
    $topic->save();

    return redirect()->route('topic.index')->with('thongbao', 'Cập nhật thành công');
}


/*destroy---------------------------------------------------------*/
    public function destroy(string $id)
    {
        $topic = Topic::onlyTrashed()->find($id);
        if ($topic === null) {
            return redirect()->route('topic.trash');
        }
    
        $topic->forceDelete(); // Xóa vĩnh viễn
        return redirect()->route('topic.trash');
    }
    /*trash---------------------------------------------------------*/
    public function trash()
    {
        $list = Topic::onlyTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    
        return view('backend.topic.trash', compact('list'));
    }
    
/*delete---------------------------------------------------------*/
    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic === null) {
            return redirect()->route('topic.index');
        }
        $topic->delete(); // Soft delete (xóa mềm)
        return redirect()->route('topic.index');
    }

/*status---------------------------------------------------------*/
    public function status($topic)
    {
        $topic = Topic::find($topic);
        if ($topic == null) {
            return redirect()->route('topic.index');
        }
    
        $topic->status = ($topic->status == 1) ? 0 : 1;
        $topic->updated_at = now();
        $topic->updated_by = Auth::id();
        $topic->save();
    
        return redirect()->route('topic.index');
    }

/*restore---------------------------------------------------------*/
    public function restore($id)
    {
        $topic = Topic::onlyTrashed()->find($id);
        if ($topic === null) {
            return redirect()->route('topic.trash');
        }
        $topic->restore();
        return redirect()->route('topic.trash');
    }
    
    
}