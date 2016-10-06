<?php

namespace Scalex\Zero\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Znck\Transformers\Traits\TransformResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, TransformResponse, ValidatesRequests;

    /**
     * Get Auth user.
     * @return \Scalex\Zero\User
     */
    protected function user() {
        return Auth::user();
    }

    protected function created($location = null) {
        $response = $this->response(Response::HTTP_CREATED);

        if ($location) {
            $response->header('Location', $location);
        }

        return $response;
    }

    protected function accepted($location = null) {
        $response = $this->response(Response::HTTP_ACCEPTED);

        if ($location) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * @param int $status
     *
     * @return \Illuminate\Http\Response
     */
    private function response($status) {
        return response('', $status);
    }
}
