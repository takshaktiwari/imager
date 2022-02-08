# Introduction

Image faker and provider package

// set dimentions
Picsum::dimensions(width: 1000, height: 1000);
Picsum::width(1000)->height(1000);

// set bucket name
Picsum::bucket(1000)

// set disk name
Picsum::disk(1000)

// seed count optinal
Picsum::seed(count: 10);

// flush bucket
Picsum::flush();

// flush and seed bucket
Picsum::refresh(count: 10);

// check if bucket empty
Picsum::isEmpty();

// get image response
Picsum::response();

// get image blur
Picsum::blur();

// get image rotate
Picsum::rotate();

// get image greyscale
Picsum::greyscale();

// get image flip
Picsum::flip();

// prepare an image
Picsum::image();

// other intervention callback function
$img = Picsum::image()->flip();
$img->others(function($img){
	$img->crop(100, 100);
});

// save generated image
Picsum::dimensions(200, 200)->save(path:'path/image.jpg');
Picsum::dimensions(200, 200)->copy(path:'path/image.jpg');
Picsum::dimensions(200, 200)->store(path:'path/image.jpg');


// resize image during save
Picsum::dimensions(200, 200)->save(path:'path/image.jpg', 100);

// save at multiple locations
Picsum::dimensions(500, 500)
	->save(path:'path/image.jpg')
	->save(path:'path/image-md.jpg', 300)
	->save(path:'path/image-sm.jpg', 100);

// get image url
Picsum::dimensions(500, 500)->image()->url();

// save path to model
Picsum::dimensions(500, 500)
	->save(path:'path/image.jpg')
	->saveModel(User::first(), 'profime_img', path:'path/image.jpg')

// get url for the image
Picsum::dimensions(500, 500)->url();

// Advance use
$post = Post::first();
Picsum::dimensions(500, 500)
	->save(path:'path/image.jpg')->saveModel($post, 'image_lg', path:'path/image.jpg')
	->save(path:'path/image-sm.jpg', 100)->saveModel($post, 'image_sm', path:'path/image-sm.jpg')
	->image(500, 400)
	->save(path:'path/image.jpg')->saveModel(Post::find(2), 'image_lg', path:'path/image.jpg')
	->url()