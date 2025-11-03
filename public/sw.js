// No-op service worker to disable previous SW and clear caches
self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    (async () => {
      const keys = await caches.keys();
      await Promise.all(keys.map((k) => caches.delete(k)));
      // Unregister this service worker
      const registration = await self.registration.unregister();
      // Claim clients so the page stops being controlled immediately
      await self.clients.claim();
    })()
  );
});

self.addEventListener('fetch', () => {
  // passthrough
});


