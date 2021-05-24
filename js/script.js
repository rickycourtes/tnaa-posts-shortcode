(function () {
  'use strict';

	var imgLoad = imagesLoaded( '.tnaa-posts' );
	imgLoad.on( 'progress', onProgress );

	function onProgress( imgLoad, image ) {
	  image.img.parentNode.classList.add(image.isLoaded ? 'loaded' : 'is-broken');
	}

}());
