<?php

namespace Takshak\Imager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PicsumController extends Controller
{
	public function index(Request $request)
	{
		$width = 1000;
		$width = $request->get('w') ? $request->get('w') : $width;
		$width = $request->get('width') ? $request->get('width') : $width;

		$height = 1000;
		$height = $request->get('h') ? $request->get('h') : $height;
		$height = $request->get('height') ? $request->get('height') : $height;

		$extension = "jpg";
		$extension = $request->get('ext') ? $request->get('ext') : $extension;
		$extension = $request->get('extension') ? $request->get('extension') : $extension;

		$image = \Picsum::dimensions($width, $height)->extension($extension);

		if ($request->get('refresh')) {
			$image->refresh((int)$request->get('refresh'));
		}
		if ($request->get('seed')) {
			$image->seed((int)$request->get('seed'));
		}
		if ($request->get('flush')) {
			$image->flush();
		}

		// generate image
		$image->image();

		if ($request->get('blur')) {
			$image->blur((int)$request->get('blur'));
		}
		if ($request->get('greyscale')) {
			$image->greyscale();
		}
		if ($request->get('flip')) {
			$image->flip($request->get('flip'));
		}
		if ($request->get('rotate')) {
			$image->rotate((int)$request->get('rotate'));
		}
		
		return $image->response();
	}
}