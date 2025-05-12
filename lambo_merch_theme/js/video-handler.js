/**
 * Video thumbnail handler - optimized for performance
 * Handles lazy loading of YouTube videos when thumbnails are clicked
 */
document.addEventListener('DOMContentLoaded', function() {
  // Select all video thumbnails
  var thumbs = document.querySelectorAll('.video-thumbnail');

  thumbs.forEach(function(container) {
    // Set pointer cursor to indicate clickability
    container.style.cursor = 'pointer';

    // Attach click handler
    container.addEventListener('click', function handler() {
      // Read video ID and start time from data attributes
      var videoId = this.dataset.videoId;
      var startTime = this.dataset.start || 0;

      // Calculate height for 16:9 aspect ratio
      var width = this.offsetWidth;
      var height = width * 0.5625;

      // Build embed URL with autoplay & start parameters
      var src = 'https://www.youtube.com/embed/' + videoId +
                '?autoplay=1&rel=0&start=' + startTime;

      // Replace thumbnail with iframe
      this.innerHTML = '<iframe width="100%" height="' + height + '" ' +
                       'src="' + src + '" frameborder="0" ' +
                       'allow="accelerometer; autoplay; clipboard-write; ' +
                       'encrypted-media; gyroscope; picture-in-picture" ' +
                       'loading="lazy" allowfullscreen></iframe>';

      // Change cursor and prevent re-embedding
      this.style.cursor = 'default';
      this.removeEventListener('click', handler);
    });
  });
});