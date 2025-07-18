<?php
namespace App\Http\Controllers\Application;


use App\Http\Controllers\Controller;

class HomeController extends Controller {

  /**
   * Summary of index
   * @return \Illuminate\Contracts\View\View
   */
  public function index() {

    return view('app.home');
  }
}