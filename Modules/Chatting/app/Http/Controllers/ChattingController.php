<?php

namespace Modules\Chatting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Chatting\Repositories\MessageRepository;

class ChattingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $imageRepository;
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }
    public function index()
    {
        return view('chatting::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chatting::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
       try {
           $this->messageRepository->postMessage($request->all());
           return response()->json(['message' => 'Message sent successfully'], 200);
       } catch (\Throwable $th) {
           return response()->json(['message' => $th->getMessage()], 500);
       }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('chatting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('chatting::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
