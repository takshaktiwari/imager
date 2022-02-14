
# Introduction

This package gives you three different tools, which are useful to fake, seed, generate placeholders and manipulate images. These tools are named as Picsum (provides images to seed database, or helps in creating model factories), Placeholder (generates placeholder images for specific location in different sizes and colours), Imager (manipulates images in desired sizes, can be used to resize an image if you don't want to cut any of edge of the images). These manipulations can be also called from the URL.

## Quick Start

Install the package with composer

    composer require takshak/imager

Simple uses

    \Picsum::dimensions(500, 500)->response();

    \Placeholder::dimensions(500, 500)->text('Some Info Text')->response();

    \Imager::init($request->file('image_file'))->resizeFit(500, 500)->response();

## Placeholder (Dummy / Avatar image provider)
You can have some fake images of may be some placeholder images with specified dimensions, having some written text and also in different colours. You can also generate user avatars also. Image can be further resized, saved to folder and also can be saved to model.

**`background($hexColor):`**  Set the color of image background

**`image($width=null, $height=null, $background=null):`** Instantiate the image if image is not already generated all the parameters are optional

**`text($text='Placeholder Image', $format=[]):`** Write text on the image and format the text as well. Possible format array keys are: size, color, align, valign, angle. Eg. 

    \Placeholder::dimensions(500, 500)
        ->text('dummy text', [
            'size'  =>  50,
            'color' =>  '#000',
            'align' =>  'center',
            'valign'    =>  'center',
            'angle'     =>  45
        ])
        ->response();

**`url():`** Generates the local URL for given type of image. Specified image can be also called by this URL

For all other functions please refer to [common methods](https://github.com/takshaktiwari/imager#common-methods)

Default values:
`$width = 500;` `$height = 500;` `$background = '#ccc';` `$extension = 'jpg';` `$textFormating = [ 'size'   =>  24, 'color' =>  '#000', 'align' =>  'center', 'valign'  =>  'center', 'angle'       =>  null ];`

### Generating placeholder image from URL
Base URL: `http://project.com/imgr/placeholder?paramters`

| Parameter | Default | Description |
|-----------|---------|-------------|
| width / w | 1000 | Width of image |
| height / h | 1000 | Height of image |
| background / bg | 'ccc' | Set the background |
| extension / ext | 'jpg' | Image format |
| text |  | Text on image |
| text_color |  | Color of text (if text parameter available)  |
| text_size | 24 | Size of the text (if text parameter available)  |
| text_angle |  | Image rotation angle (if text parameter available)  |
| text_align | center | Text alignment (if text parameter available)  |
| text_valign | center | Vertical alignment (if text parameter available)  |
| blur | 1 | Blur image, pass the blur amount  |
| greyscale | | Make image greyscale  |
| flip | | Flip the image. Possible values: v / h |
| rotate | | Rotates image  |

Sample image URL: `http://project.com/imgr/placeholder?w=150&h=150&text=JD&text_size=60&background=c00c0c`

## Picsum (Fake image provider)

It provides some images to fake database or can used as placeholder. This stores some images to it's bucket and then returns randomly generated images as requested. Functions and default parameters are given below:

**`bucket($foldername):`** Name of source folder from where the images will be faked. If not setted default 'imgr-bucket' folder will be used.

**`disk($disk='local'):`** Storage disk name

**`seed(int: $count=10):`** Seed the bucket with some dummy images

**`flush():`** Flush all the images from bucket

**`refresh(int: $count=10):`** Flush all the images from bucket and seed new images

**`isEmpty():`** Checks if the bucket is empty

**`url():`** Generates the local URL for given type of image. Specified image can be also called by this URL

**`image():`** Instantiate the image if image is not already generated

For all other functions please refer to [common methods](https://github.com/takshaktiwari/imager#common-methods)

## Imager (Easy image manipulation)

This can used to resize or fit an image within a dimensions or for other manipulations. This provides following methods:

**`init($image):`** Receives an image file / path / URL to work on 

**`resizeHeight(int: $height):`** Defines the height of the image in pixels. (parameter optional if height() function has been already called)

**`resize(int: $width, int: $height):`** Defines the width and height of the image in pixels (image may squeeze or edges can be cropped). (parameters are optional if height(), width() or dimensions() function has been already called).

`**resizeFit(int: $width, int: $height):**` Defines the width and height of the image in pixels whichever fits the best, none of the edge will be cropped and image will never stretch. (parameters are optional if height(), width() or dimensions() function has been already called) 

**`inCanvas($bg=null):`** If you want to generate image with any coloured background, eg. (#fff)

For all other functions please refer to [common methods](https://github.com/takshaktiwari/imager#common-methods)

## Common Methods

Following methods can be called to all above tools

**`width(int: $width):`** Define the width of image

**`height(int: $height):`** Define the height of image

**`dimensions(int: $dimensions):`** Width and height can be defined at once usin this function instead of *width()* and *height(*)

**`extension($extention):`** Extension of image, eg: 'png' or 'jpg'

**`response($extention=null):`** Returns the image as a response.

**`basePath($path):`** Set the base folder name where you want to store the image

**`save($path, $width=null):`** Save the path to any location. Width parameter is optional. Image will get resized were width will be passed

**`saveModel($model, $column, $filePath):`** Saves image path to the model.

**`blur(int: $amount=1):`** Blur the image

**`greyscale():`** Makes image grey scale

**`rotate(int: $deg=45):`** Rotates image on *$deg* degree

**`flip($direction='h'):`** Flips the image, possible values(v or h)

**`others(function($image){}):`** Passes the image through other function (intervention/image) for further manipulations.


## Placeholder - Some Uses
Getting Default dummy image

    \Placeholder::text('Some Info Text')->response();

Customised Text in image

    \Placeholder::text('Some Info Text', [
        'size'  =>  24,
        'color' =>  '#000',
        'align' =>  'center',
        'valign'    =>  'center',
        'angle'     =>  45
    ])->response();

Create dummy user avatar

    \Placeholder::dimensions(200, 200)->text('JD')->response();

Save image to folder and model

    \Placeholder::text('Some dummy text')
    ->basePath(\Storage::disk('local')->path('images'))
    ->save('image-lg.jpg')
    ->saveModel($user, 'profile_img', 'image-lg.jpg')
    ->save('image-md.jpg', 300)
    ->saveModel($user, 'profile_img', 'image-md.jpg')
    ->response();

## Picsum - Some Uses

Resize image during save

    Picsum::dimensions(200, 200)->save(path:'path/image.jpg', 100);

Save at multiple locations

    Picsum::dimensions(500, 500)
        ->save(path:'path/image.jpg')
        ->save(path:'path/image-md.jpg', 300)
        ->save(path:'path/image-sm.jpg', 100);

Get image URL

    Picsum::dimensions(500, 500)->image()->url();

Save path to model

    Picsum::dimensions(500, 500)
        ->save(path:'path/image.jpg')
        ->saveModel(User::first(), 'profime_img', path:'path/image.jpg');

Get URL for the image

    Picsum::dimensions(500, 500)->url();

Other intervention callback function

    $img = Picsum::image()->flip();
    $img->others(function($img){
        $img->crop(100, 100);
    });
    return $img->response();

Save image to a model

    $post = Post::first();
    Picsum::dimensions(500, 500)
        ->save(path:'path/image.jpg')->saveModel($post, 'image_lg', path:'path/image.jpg')
        ->save(path:'path/image-sm.jpg', 100)->saveModel($post, 'image_sm', path:'path/image-sm.jpg')
        ->image(500, 400)
        ->save(path:'path/image.jpg')->saveModel(Post::find(2), 'image_lg', path:'path/image.jpg')
        ->url()
