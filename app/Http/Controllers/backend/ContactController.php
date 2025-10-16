<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $list = Contact::orderBy('created_at', 'desc')->paginate(5);
        return view('backend.contact.index', compact('list'));
    }

    public function create()
    {
        return view('backend.contact.create');
    }

    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());
        return redirect()->route('contact.index')->with('thongbao', 'Tạo liên hệ mới thành công');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('backend.contact.edit', compact('contact'));
    }

    public function update(StoreContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->fill($request->only('name', 'email', 'phone', 'title', 'content', 'status'));
        $contact->save();

        return redirect()->route('contact.index')->with('thongbao', 'Cập nhật liên hệ thành công');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contact.index')->with('thongbao', 'Xóa tạm thời thành công');
    }

    public function trash()
    {
        $list = Contact::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('backend.contact.trash', compact('list'));
    }
    public function show($id)
{
    $contact = Contact::findOrFail($id);
    return view('backend.contact.show', compact('contact'));
}


    public function restore($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();
        return redirect()->route('contact.trash')->with('thongbao', 'Khôi phục liên hệ thành công');
    }

    public function delete($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->forceDelete();
        return redirect()->route('contact.trash')->with('thongbao', 'Xóa vĩnh viễn thành công');
    }

    public function status($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = !$contact->status;
        $contact->save();

        return redirect()->route('contact.index')->with('thongbao', 'Đã đổi trạng thái thành công');
    }

    public function reply($id)
    {
        $contact = Contact::findOrFail($id);
        return view('backend.contact.reply', compact('contact'));
    }

    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply_content' => 'required|string',
        ]);
    
        $contact = Contact::findOrFail($id);
    
        // Lưu nội dung phản hồi và đánh dấu đã phản hồi
        $contact->reply_content = $request->reply_content;
        $contact->reply_id = auth()->id() ?? 1; // Ghi ID người phản hồi, mặc định là 1 nếu chưa đăng nhập
        $contact->save();
    
        // Gửi email
        Mail::raw($request->reply_content, function ($message) use ($contact) {
            $message->to($contact->email)
                    ->subject('Phản hồi liên hệ');
        });
    
        return redirect()->route('contact.index')->with('thongbao', 'Đã gửi phản hồi đến người liên hệ.');
    }
    

}
