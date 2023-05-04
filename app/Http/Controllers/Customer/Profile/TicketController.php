<?php

namespace App\Http\Controllers\Customer\Profile;

use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Http\Requests\Customer\Profile\StoreTicketRequest;
use App\Http\Services\File\FileService;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketFile;
use App\Models\Ticket\TicketPriority;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->tickets()->where(['ticket_id' => null])->get();
        return view('customer.profile.tickets.my-ticket', compact('tickets'));
    }
    public function create()
    {
        $categories = TicketCategory::all();
        $priorities = TicketPriority::all();
        return view('customer.profile.tickets.my-ticket-create', compact('categories', 'priorities'));
    }
    public function store(StoreTicketRequest $request, FileService $fileService)
    {
        DB::transaction(function () use($request, $fileService){
        $inputs = $request->all();
        $inputs['seen'] = 0;
        $inputs['reference_id'] = null;
        $inputs['user_id'] = Auth::user()->id;
        $inputs['status'] = 1;
        $ticket = Ticket::create($inputs);

        //file        
        if ($request->hasFile('file')) {
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            // $result = $fileService->moveToPublic($request->file('file'));
            $result = $fileService->moveToStorage($request->file('file'));
            $fileFormat = $fileService->getFileFormat();

            if ($result === false) {
                return to_route('home.profile.my-ticket')->with('alert-error', 'آپلود فایل با خطا مواجه شد');
            }
            $inputs['ticket_id'] = $ticket->id;
            $inputs['user_id'] = Auth::user()->id;
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
            $file = TicketFile::create($inputs);
        }
        });

        return redirect()->route('home.profile.my-ticket')->with('alert-success', 'تیکت شما با موفقیت ثبت شد');
    }
    public function show(Ticket $ticket)
    {
        return view('customer.profile.tickets.my-ticket-show', compact('ticket'));
    }

    public function answer(TicketRequest $request, Ticket $ticket)
    {

        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 0;
        $inputs['reference_id'] = $ticket->reference_id;
        $inputs['user_id'] = Auth::user()->id;
        $inputs['category_id'] = $ticket->category_id;
        $inputs['priority_id'] = $ticket->priority_id;
        $inputs['ticket_id'] = $ticket->id;
        $inputs['status'] = 1;
        $ticket = Ticket::create($inputs);
        return redirect()->back()->with('alert-success', 'پاسخ شما با موفقیت ثبت شد');
    }


    public function change(Ticket $ticket)
    {
        $ticket->status = 0;
        $result = $ticket->save();
        return redirect()->route('home.profile.my-ticket')->with('alert-success', 'تیکت مورد نظر با موفقیت بسته شد');
    }
    public function download(Ticket $ticket)
    {
        $url = storage_path($ticket->file->file_path);
        if(file_exists($url))
        {
            return response()->download($url);
        }else{
            return back()->with('alert-error', 'خطا هنگام دانلود');
        }
    }
}
