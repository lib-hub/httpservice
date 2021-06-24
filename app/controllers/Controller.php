<?php

namespace app\controllers;

use components\http\Response;
use components\http\Request;

abstract class Controller
{
    /**
     * Action for GET method
     *
     * @param Request $request
     * @return Response
     */
    abstract public function index($request);

    /**
     * Action for GET method with parameter
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    abstract public function retrieve($id, $request);

    /**
     * Action for POST method
     *
     * @param Request $request
     * @return Response
     */
    abstract public function create($request);

    /**
     * Action for PUT/PATCH method
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    abstract public function update($id, $request);

    /**
     * Action for DELETE method
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    abstract public function destroy($id, $request);
}