<?php

namespace app\controllers;

use components\http\Response;
use components\http\Request;

class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Action for GET method
     *
     * @param Request $request
     * @return Response
     */
    public function index($request)
    {
        // TODO: Implement index() method.
    }

    /**
     * Action for GET method with parameter
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function retrieve($id, $request)
    {
        // TODO: Implement retrieve() method.
    }

    /**
     * Action for POST method
     *
     * @param Request $request
     * @return Response
     */
    public function create($request)
    {
        // TODO: Implement create() method.
    }

    /**
     * Action for PUT/PATCH method
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update($id, $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * Action for DELETE method
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function destroy($id, $request)
    {
        // TODO: Implement destroy() method.
    }
}