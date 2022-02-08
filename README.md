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