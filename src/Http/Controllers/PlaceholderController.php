<?php

namespace Takshak\Imager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceholderController extends Controller
{
	public function index(Request $request)
	{
		$width = 500;
		$width = $request->get('w') ? $request->get('w') : $width;
		$width = $request->get('width') ? $request->get('width') : $width;

		$height = 500;
		$height = $request->get('h') ? $request->get('h') : $height;
		$height = $request->get('height') ? $request->get('height') : $height;

		$background = "#ccc";
		$background = $request->get('bg') ? $request->get('bg') : $background;
		$background = $request->get('background') ? $request->get('background') : $background;

		$image = \Placeholder::dimensions($width, $height)
		->background($background);

		if ($request->get('text')) {
			$format = [];
			if ($request->get('text_color')) {
				$format['color'] = $request->get('text_color');
			}
			if ($request->get('text_size')) {
				$format['size'] = $request->get('text_size');
			}
			if ($request->get('text_angle')) {
				$format['angle'] = $request->get('text_angle');
			}
			if ($request->get('text_align')) {
				$format['align'] = $request->get('text_align');
			}
			if ($request->get('text_valign')) {
				$format['valign'] = $request->get('text_valign');
			}

			$image->text($request->get('text'), $format);
		}

		$image->others(function($image) use($request){
			if ($request->get('blur')) {
				$image->blur((int)$request->get('blur'));
			}
			if ($request->get('flip')) {
				$image->flip($request->get('flip'));
			}
		});

		return $image->response();
	}
}