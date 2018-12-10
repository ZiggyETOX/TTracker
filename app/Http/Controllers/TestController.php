<?php

namespace App\Http\Controllers;

class TestController extends Controller {
	public function test() {

		// $product = \App\Product::find(1);
		// dd($product);

		$return['products'] = \App\Product::all();
		return view('/mailer/overview', $return);

		// $product = new \App\Product;
		// $product->name = 'Ettiene';
		// $product->price = 7.5;
		// $product->stock = 5;
		// $product->save();

	}

}
