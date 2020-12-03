<?php


namespace App\Http\Contracts;


interface PlayerInterface{
    public function index();
    public function show($id);
    public function create($credentials);
    public function update($credentials,$id);
}
