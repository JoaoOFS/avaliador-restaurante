@extends('layouts.app')

@section('title', 'Mapa de Restaurantes')

@section('content')
    <div class="card">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Mapa -->
            <div class="flex-1 h-[600px] rounded-lg overflow-hidden">
                <div id="map" class="w-full h-full"></div>
            </div>

            <!-- Lista de Restaurantes -->
            <div class="w-full md:w-80 space-y-4">
                <div class="relative">
                    <input type="text"
                           id="searchMap"
                           placeholder="Buscar no mapa..."
                           class="input pl-10 w-full">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                    @foreach($restaurants as $restaurant)
                        <div class="card hover-lift cursor-pointer restaurant-card"
                             data-lat="{{ $restaurant->latitude }}"
                             data-lng="{{ $restaurant->longitude }}"
                             data-name="{{ $restaurant->name }}"
                             data-rating="{{ $restaurant->reviews->avg('rating') }}"
                             data-address="{{ $restaurant->address }}"
                             data-photo="{{ $restaurant->photos->first()?->url }}">
                            <div class="flex items-start gap-4">
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($restaurant->photos->isNotEmpty())
                                        <img src="{{ $restaurant->photos->first()->url }}"
                                             alt="{{ $restaurant->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                                            <i class="fas fa-utensils text-xl text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-1">{{ $restaurant->name }}</h3>
                                    <div class="flex items-center text-sm text-gray-400 mb-1">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}
                                    </div>
                                    <p class="text-sm text-gray-400 line-clamp-2">
                                        {{ $restaurant->address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa o mapa
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: { lat: -23.550520, lng: -46.633308 }, // São Paulo
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "geometry",
                        "stylers": [{"color": "#242f3e"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.stroke",
                        "stylers": [{"lightness": -80}]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#746855"}]
                    },
                    {
                        "featureType": "administrative.locality",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#d59563"}]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#d59563"}]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{"color": "#263c3f"}]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#6b9a76"}]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{"color": "#38414e"}]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [{"color": "#212a37"}]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#9ca5b3"}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{"color": "#746855"}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [{"color": "#1f2835"}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#f3d19c"}]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [{"color": "#2f3948"}]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#d59563"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"color": "#17263c"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#515c6d"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.stroke",
                        "stylers": [{"lightness": -20}]
                    }
                ]
            });

            // Array para armazenar os marcadores
            const markers = [];
            const infoWindows = [];

            // Função para criar o conteúdo do InfoWindow
            function createInfoWindowContent(restaurant) {
                return `
                    <div class="p-2">
                        <div class="flex items-start gap-3">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                ${restaurant.photo ?
                                    `<img src="${restaurant.photo}" alt="${restaurant.name}" class="w-full h-full object-cover">` :
                                    `<div class="w-full h-full bg-gray-800 flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-600"></i>
                                    </div>`
                                }
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">${restaurant.name}</h3>
                                <div class="flex items-center text-sm text-gray-600 mb-1">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    ${restaurant.rating}
                                </div>
                                <p class="text-sm text-gray-600">${restaurant.address}</p>
                                <a href="/restaurants/${restaurant.id}"
                                   class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Adiciona os marcadores ao mapa
            document.querySelectorAll('.restaurant-card').forEach((card, index) => {
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);
                const name = card.dataset.name;
                const rating = card.dataset.rating;
                const address = card.dataset.address;
                const photo = card.dataset.photo;

                const marker = new google.maps.Marker({
                    position: { lat, lng },
                    map,
                    title: name,
                    animation: google.maps.Animation.DROP
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: createInfoWindowContent({
                        name,
                        rating,
                        address,
                        photo
                    })
                });

                marker.addListener('click', () => {
                    infoWindows.forEach(iw => iw.close());
                    infoWindow.open(map, marker);
                });

                card.addEventListener('click', () => {
                    map.setCenter({ lat, lng });
                    map.setZoom(15);
                    infoWindows.forEach(iw => iw.close());
                    infoWindow.open(map, marker);
                });

                markers.push(marker);
                infoWindows.push(infoWindow);
            });

            // Busca no mapa
            const searchInput = document.getElementById('searchMap');
            const searchBox = new google.maps.places.SearchBox(searchInput);

            map.addListener('bounds_changed', () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener('places_changed', () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) return;

                const bounds = new google.maps.LatLngBounds();
                places.forEach(place => {
                    if (!place.geometry || !place.geometry.location) return;

                    bounds.extend(place.geometry.location);
                });

                map.fitBounds(bounds);
            });
        });
    </script>
@endpush
