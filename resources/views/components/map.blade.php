{{-- Add required CSS in the head --}}
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" 
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>
@endpush

<div x-data="mapComponent()"
     x-init="initMap()"
     wire:ignore
     class="filament-forms-map-component">
    {{-- تكبير حجم الخريطة --}}
    <div id="map" class="w-full rounded-lg border border-gray-300 shadow-sm" style="height: 600px;"></div>
</div>

@push('scripts')
{{-- Add Leaflet JS after the page loads --}}
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

<script>
    function mapComponent() {
        return {
            map: null,
            marker: null,
            
            initMap() {
                // تغيير الموقع الافتراضي إلى ليبيا
                const defaultLocation = [32.8872, 13.1913]; // طرابلس، ليبيا
                const defaultZoom = 13; // تكبير الخريطة افتراضياً
                
                // تهيئة الخريطة مع تأخير بسيط لضمان تحميل العنصر
                setTimeout(() => {
                    this.map = L.map('map').setView(defaultLocation, defaultZoom);
                    
                    // Add tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(this.map);
                    
                    // Add marker
                    this.marker = L.marker(defaultLocation).addTo(this.map);
                    
                    // Handle click events
                    this.map.on('click', (e) => this.updateMarker(e.latlng));
                    
                    // Initialize existing coordinates
                    this.initializeExistingLocation();
                }, 100);
            },
            
            initializeExistingLocation() {
                const lat = @js($getState()['latitude'] ?? null);
                const lng = @js($getState()['longitude'] ?? null);
                
                if (lat && lng) {
                    this.updateMarker(L.latLng(lat, lng));
                }
            },
            
            updateMarker(latlng) {
                const zoomLevel = 15;
                
                this.marker.setLatLng(latlng);
                this.map.setView(latlng, zoomLevel);
                
                // Update Livewire state
                @this.set('latitude', latlng.lat);
                @this.set('longitude', latlng.lng);
            }
        }
    }
</script>
