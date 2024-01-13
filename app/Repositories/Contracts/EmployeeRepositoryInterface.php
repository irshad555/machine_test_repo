<?php

namespace App\Repositories\Contracts;

interface EmployeeRepositoryInterface
{
    public function all($params);
    public function save($request);
    public function get($id);
    public function update($request, $id);
    public function delete($id);
}
