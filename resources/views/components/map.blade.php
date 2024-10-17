<div x-data="mapComponent()"
     x-init="initMap()"
     wire:ignore
     class="filament-forms-map-component">
    <div id="map" style="height: 400px; width: 100%;"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    function mapComponent() {
        return {
            map: null,
            marker: null,
            initMap() {
                this.map = L.map('map').setView([0, 0], 2);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(this.map);

                this.marker = L.marker([0, 0]).addTo(this.map);

                this.map.on('click', (e) => {
                    this.updateMarker(e.latlng);
                });

                // Initialize with existing values if available
                let lat = @js($getState()['latitude'] ?? null);
                let lng = @js($getState()['longitude'] ?? null);
                if (lat && lng) {
                    this.updateMarker(L.latLng(lat, lng));
                }
            },
            updateMarker(latlng) {
                this.marker.setLatLng(latlng);
                this.map.setView(latlng, 15);

                // Update Livewire component state
                @this.set('latitude', latlng.lat);
                @this.set('longitude', latlng.lng);
            }
        }
    }
</script>
