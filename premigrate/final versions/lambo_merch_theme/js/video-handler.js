document.addEventListener('DOMContentLoaded', function() {
  // 1. Select all thumbnails
  var thumbs = document.querySelectorAll('.video-thumbnail');  // :contentReference[oaicite:8]{index=8}

  thumbs.forEach(function(container) {
    // 2. Set pointer cursor
    container.style.cursor = 'pointer';

    // 3. Attach click handler
    container.addEventListener('click', function handler() {  // :contentReference[oaicite:9]{index=9}
      // 4. Read video ID and start time
      var videoId   = this.dataset.videoId;                 // :contentReference[oaicite:10]{index=10}
      var startTime = this.dataset.start || 0;              // :contentReference[oaicite:11]{index=11}

      // 5. Calculate height for 16:9 aspect ratio
      var width  = this.offsetWidth;
      var height = width * 0.5625;                          // :contentReference[oaicite:12]{index=12}

      // 6. Build embed URL with autoplay & start
      var src = 'https://www.youtube.com/embed/' + videoId +
                '?autoplay=1&rel=0&start=' + startTime;     // :contentReference[oaicite:13]{index=13}

      // 7. Inject the iframe
      this.innerHTML = '<iframe width="100%" height="' + height + '" ' +
                       'src="' + src + '" frameborder="0" ' +
                       'allow="accelerometer; autoplay; clipboard-write; ' +
                       'encrypted-media; gyroscope; picture-in-picture" ' +
                       'allowfullscreen></iframe>';           // :contentReference[oaicite:14]{index=14}

      // 8. Clean up so it won’t re‑embed
      this.style.cursor = 'default';
      this.removeEventListener('click', handler);           // :contentReference[oaicite:15]{index=15}
    });
  });
});
