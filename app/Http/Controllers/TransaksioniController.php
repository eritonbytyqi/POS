<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksionRequest;
use Illuminate\Http\Request;
use App\Services\TransaksioniService;  // Shërbimi për transaksionet
use App\Http\Resources\TransaksioniResource;  // Resursi për transaksionet
use App\Http\Resources\TransaksioniCollection;  // Koleksioni i transaksionet
use App\Http\Resources\EmptyResource;  // Për resurset bosh
use App\Http\Traits\Helpers\ApiResponseTrait;
use Exception;

class TransaksioniController extends Controller
{
    use ApiResponseTrait;
    protected TransaksioniService $TransaksioniService;

    public function __construct(TransaksioniService $TransaksioniService)
    {
        $this->TransaksioniService = $TransaksioniService;
    }

    /**
     * Shfaq të gjitha transaksionet.
     */
    public function index()
    {
        try {
            $transaksionet = $this->TransaksioniService->all(); // Merr të gjitha transaksionet
            if ($transaksionet->isEmpty()) {
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new TransaksioniCollection($transaksionet));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim: ' . $e->getMessage());
        }
    }

    /**
     * Ruaj një transaksion të ri.
     */
    public function store(Request $request)
    {
        try {
            $transaksioni = $this->TransaksioniService->save($request); // Ruaj transaksionin
            return $this->created(new TransaksioniResource($transaksioni));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);


        }
    }

    /**
     * Shfaq një transaksion të caktuar.
     */
    public function show($id)
    {
        try {
            $transaksioni = $this->TransaksioniService->find($id); // Gjej transaksionin me ID
            if ($transaksioni) {
                return $this->okWithResource(new TransaksioniResource($transaksioni));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Përshtat një transaksion ekzistues.
     */
    public function update(Request $request, $id)
    {
        try {
            $transaksioni = $this->TransaksioniService->find($id); // Gjej transaksionin me ID
            if ($transaksioni) {
                $transaksioni = $this->TransaksioniService->update($request, $id); // Përshtat transaksionin
                return $this->okWithResource(new TransaksioniResource($transaksioni));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Fshi një transaksion nga ruajtja.
     */
    public function destroy($id)
    {
        try {
            $transaksioni = $this->TransaksioniService->find($id); // Gjej transaksionin me ID
            if ($transaksioni) {
                $this->TransaksioniService->delete($id); // Fshi transaksionin
                return $this->deleted(new EmptyResource($transaksioni));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
}
