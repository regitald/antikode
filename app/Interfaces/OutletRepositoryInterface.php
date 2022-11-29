<?php

namespace App\Interfaces;

interface OutletRepositoryInterface
{
    public function fetch($request);
    public function store(array $data);
    public function show($id);
    public function update($id, array $data);
    public function destroy($id);
}
