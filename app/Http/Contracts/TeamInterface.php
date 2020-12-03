<?php


namespace App\Http\Contracts;


interface TeamInterface{
    public function index();
    public function show($categoryID);
    public function create($credentials);
    public function update($credentials,$id);
    public function delete($id);
}
