<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$return['products'] = \App\Product::all();
		return view('/mailer/productsOverview', $return);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		return view('/mailer/createform');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$product = new \App\Product;
		// $product->name = $request->input('name');
		// $product->price = $request->input('price');
		// $product->stock = $request->input('stock');

		foreach ($request->all() as $key => $value) {

			switch ($key) {
			case 'name':
			case 'description':
			case 'promo':
			case 'price':
			case 'stock':
				// case 'value':
				$product->$key = $value;
				break;

			default:
				# code...
				break;
			}
		}
		// dd($request->file('file'));
		if ($request->hasFile('file') && $request->file('file')->isValid()) {
			# code...
			$location = Storage::putFile('public/products', $request->file('file'));
			// dd($location);
			$product->file = $location;
			$product->save();

			return redirect('/products');
		} else {

			return redirect('/products/create')->with(['message' => 'There was a problem with your file upload. Please try to submit again.', 'message_header' => 'Submission Unsuccessful']);

		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product) {
		//dd($product);
		$return['products'] = $product;
		//dd($return);
		return view('/mailer/showProduct', $return);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Product $product) {

		$return['products'] = $product;
		return view('/mailer/editform', $return);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Product $product) {

		// dd($request->all());

		// $product->name = $request->input('name');
		// $product->price = $request->input('price');
		// $product->stock = $request->input('stock');

		foreach ($request->all() as $key => $value) {

			switch ($key) {
			case 'name':
			case 'description':
			case 'promo':
			case 'price':
			case 'stock':
				// case 'value':
				$product->$key = $value;
				break;

			default:
				# code...
				break;
			}
		}

		if ($request->hasFile('file') && $request->file('file')->isValid()) {

			$location = Storage::putFile('public/products', $request->file('file'));
			$product->file = $location;
			$product->save();

			return redirect('/products');
		} else {

			if ($request->input('fileOption') == '1') {
				$location = $request->input('file');
				$product->file = $location;
				$product->save();

				return redirect('/products');
			} else {
				return redirect('/products/' . $product->id . '/edit')->with(['message' => 'There was a problem with your file upload. Please try to submit again.', 'message_header' => 'Submission Unsuccessful']);
			}

		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product) {

		$product->delete();

		return redirect('/products');
	}
}
