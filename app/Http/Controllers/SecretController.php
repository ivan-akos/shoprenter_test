<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowSecretRequest;
use App\Http\Requests\StoreSecretRequest;
use App\Http\Requests\UpdateSecretRequest;
use App\Models\Secret;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class SecretController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param String $hash
     * @return Response
     */
    public function show(String $hash): Response
    {
        //$validated = $request;//->validated();
        $secret = Secret::find($hash);

        if (!$secret ||
            $secret->expiresAt <= now() ||
            $secret->remainingViews == 0) {
            return response([
                'message' => 'Secret not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $secret->remainingViews -= 1;
        $secret->save();

        return response([
            'hash' => $secret->hash,
            'secretText' => $secret->secretText,
            'createdAt' => $secret->createdAt,
            'expiresAt' => $secret->expiresAt,
            'remainingViews' => $secret->remainingViews
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSecretRequest $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $validated = $request;//->validated();
        $hash = hash('sha256', now()->timestamp); //unique identifier from current timestamp

        $secret = new Secret([
            'hash' => $hash,
            'secretText' => $validated['secretText'],
            'createdAt' => now(),
            'expiresAt' => now()->modify("+{$validated['expiresAfter']} minutes"),
            'remainingViews' => $validated['remainingViews']
        ]);

        $secret->save();

        return response([
            'hash' => $secret['hash'],
            'secretText' => $secret['secretText'],
            'createdAt' => $secret['createdAt'],
            'expiresAt' => $secret['expiresAt'],
            'remainingViews' => $secret['remainingViews']
        ], Response::HTTP_OK );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secret $secret)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSecretRequest $request, Secret $secret)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secret $secret)
    {
        //
    }
}
