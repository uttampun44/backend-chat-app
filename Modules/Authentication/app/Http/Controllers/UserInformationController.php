<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Authentication\app\Repositories\UserInformationRepository;
use Modules\Authentication\Http\Requests\UserInformationRequest;

class UserInformationController extends Controller
{
    protected $repository;

    public function __construct(UserInformationRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $users =  $this->repository->userLists();

       return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authentication::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserInformationRequest $request)
    {
        try {
            $this->repository->userInformationCreateOrUpdate($request->validated());
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authentication::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('authentication::edit');
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
