<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNumberRequest;
use App\Services\PhonesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PhonesController
 * @package App\Http\Controllers\Api
 */
class PhonesController extends Controller
{
    /**
     * @var PhonesService
     */
    private $service;


    public function __construct(PhonesService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 15);
        return response($this->service->getList($limit), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function show($id)
    {
        return response($this->service->get($id), Response::HTTP_OK);
    }



    /**
     * @param CreateNumberRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function create(CreateNumberRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        return response($this->service->create($data), Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        return response($this->service->update($id, $data), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->service->delete($id);
        return response('', Response::HTTP_NO_CONTENT);
    }
}
