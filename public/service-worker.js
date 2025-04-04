self.addEventListener('install', (event) => {
    event.waitUntil(
      caches.open('sellmate-cache').then((cache) => {
        return cache.addAll([
          '/',
          '/sellmate/',
          '/sellmate/index.html',
          '/sellmate/css/app.css',
          '/sellmate/js/app.js',
          '/sellmate/icons/icon-192x192.png',
          '/sellmate/icons/icon-512x512.png'
        ]);
      })
    );
  });
  
  self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        return cachedResponse || fetch(event.request);
      })
    );
  });
  