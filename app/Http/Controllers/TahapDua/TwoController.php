<?php
namespace App\Http\Controllers\TahapDua;


use App\Http\Controllers\Controller;

class TwoController extends Controller {

  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index() {

    return view('tahapdua.home');
  }
}