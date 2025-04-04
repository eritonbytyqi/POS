const manifest = {
    "name": "SellMate",
    "short_name": "SellMate",
    "description": "A modern application for managing sales and products.",
    "start_url": "/sellmate/",
    "display": "standalone",
    "background_color": "#ffffff",
    "theme_color": "#000000",
    "icons": [
      {
        "src": "/sellmate/icons/icon-192x192.png",
        "sizes": "192x192",
        "type": "image/png"
      },
      {
        "src": "/sellmate/icons/icon-512x512.png",
        "sizes": "512x512",
        "type": "image/png"
      }
    ]
  };
  
  // I shkruajmë manifestin në një skedar të jashtëm
  if (typeof module !== 'undefined' && module.exports) {
    module.exports = manifest;
  } else {
    window.manifest = manifest;
  }
  