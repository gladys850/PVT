<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        <v-row>
          <v-col cols="12" md="12">
            <div><strong>Buscar las ubicación en:</strong> {{ departamentoSeleccionado }}</div>
          </v-col>
          <v-col cols="12" md="12">
            <v-autocomplete
              dense
              filled
              outlined
              shaped
              label="Buscar por provincia o municipio"
              v-model="provinciaSeleccionada"
              :items="provinciasFiltradas"
              @change="buscarDireccion"
              clearable
            />
          </v-col>
          <v-col cols="12" md="12">
            <v-text-field
              label="Buscar un término de calle, avenida, plaza u otro lugar"
              v-model="direccion"
              @keyup.enter="buscarDireccion"
              append-icon="mdi-magnify"
              @click:append="buscarDireccion"
              dense
              outlined
              clearable
            />
          </v-col>
          <v-col cols="12" md="12">
            <div><strong>Buscar por URL de Google Maps</strong></div>
          </v-col>
          <v-col cols="12" md="12">
            <v-textarea
              v-model="url"
              label="Pega la URL compartida de Google Maps"
              @keyup.enter="procesarURL"
              append-icon="mdi-map-marker"
              @click:append="procesarURL"
              clearable
              @focus="limpiarCampos"
              rows="2"
              outlined
            />
          </v-col>
          <v-col cols="12" md="12">
            <div><strong>Buscar por coordenadas</strong></div>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field outlined dense label="Latitud" v-model="latInput"  />
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field outlined dense label="Longitud" v-model="lngInput" />
          </v-col>
          <v-col cols="12" md="4">
            <v-btn icon text color="primary" @click="centrarPorCoordenadas">
              <v-icon>mdi-map-marker</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="8">
        <div id="map" style="height: 500px; margin-top: 20px;"></div>

        <v-card v-if="direccionSeleccionada" class="mt-4">
          <v-card-text>
            <p><strong>Dirección seleccionada:</strong> {{ direccionSeleccionada }}</p>
            <v-btn color="primary" @click="imprimir">Imprimir ubicación</v-btn>
          </v-card-text>
        </v-card>

        <div id="direccion-print" v-if="direccionSeleccionada">
          Dirección: {{ direccionSeleccionada }}
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import L from 'leaflet';

export default {
  name: 'LMap',
  props: {
    address: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      map: null,
      marker: null,
      direccion: '',
      provinciaSeleccionada: '',
      direccionSeleccionada: '',
      lat: null,
      lng: null,
      latInput: '',
      lngInput: '',
      url: '',
      departamentos: [],
      provinciasFiltradas: [],
      limitesDepartamentos: {},
      boundaryRectangle: null,
      geojsonLayer: null,
      geojsonData: null,
      ubicaciones: [],
      departamentoIdNombreMap: {}
    };
  },
  computed: {
    departamentoSeleccionado() {
      return this.departamentoIdNombreMap[this.address.city_address_id] || '';
    }
  },
  watch: {
    departamentoSeleccionado(nuevo) {
      if (nuevo) {
        this.filtrarProvincias(nuevo);
        // Solo centrar si NO hay coordenadas previas
        if (!this.address.latitude || !this.address.longitude) {
          this.centrarEnDepartamento();
          this.buscarDireccion();
        }
      }
    },
    provinciaSeleccionada() {
      this.buscarDireccion();
    }
  },
  mounted() {
    this.$nextTick(async () => {
      this.inicializarMapa();
      await this.cargarUbicaciones();
      await this.cargarGeoJSON();

      // Usar coordenadas del padre si existen
      if (this.address.latitude && this.address.longitude) {
        this.latInput = this.address.latitude;
        this.lngInput = this.address.longitude;
        this.centrarPorCoordenadas();
      }
    });
  },
  methods: {
    inicializarMapa() {
      this.map = L.map('map').setView([-16.5, -68.15], 6);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(this.map);

      this.map.on('click', async (e) => {
        const { lat, lng } = e.latlng;
        const limites = this.limitesDepartamentos[this.departamentoSeleccionado];
        if (limites) {
          const dentro = (
            lat >= limites.minLat &&
            lat <= limites.maxLat &&
            lng >= limites.minLng &&
            lng <= limites.maxLng
          );
          if (!dentro) {
            alert('Ubicación fuera del departamento seleccionado');
            return;
          }
        }
        this.lat = lat;
        this.lng = lng;
        this.latInput = lat;
        this.lngInput = lng;
        this.colocarMarcador(lat, lng);
        await this.obtenerDireccion(lat, lng);
      });
    },

    colocarMarcador(lat, lng) {
      if (this.marker) {
        this.marker.setLatLng([lat, lng]);
      } else {
        this.marker = L.marker([lat, lng]).addTo(this.map);
      }
      this.address.latitude = lat;
      this.address.longitude = lng;
    },

    async obtenerDireccion(lat, lng) {
      const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
      const response = await fetch(url);
      const data = await response.json();
      this.direccionSeleccionada = data.display_name || 'Dirección no disponible';
    },

    async buscarDireccion() {
      if (!this.departamentoSeleccionado) return;
      const partes = [];
      if (this.direccion) partes.push(this.direccion);
      if (this.provinciaSeleccionada) {
        const partesProv = this.provinciaSeleccionada.split(',').map(p => p.trim()).reverse();
        partes.push(...partesProv);
      }
      partes.push(this.departamentoSeleccionado);
      partes.push('Bolivia');

      const consulta = partes.join(', ');
      const limites = this.limitesDepartamentos[this.departamentoSeleccionado];
      let viewbox = '';
      if (limites) {
        const { minLat, maxLat, minLng, maxLng } = limites;
        viewbox = `&viewbox=${minLng},${maxLat},${maxLng},${minLat}&bounded=1`;
      }

      const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(consulta)}&format=json&addressdetails=1&limit=1${viewbox}`;
      const response = await fetch(url, {
        headers: { 'User-Agent': 'TuAppMapa/1.0 (tucorreo@dominio.com)' }
      });

      const data = await response.json();
      if (data.length > 0) {
        const ubicacion = data[0];
        this.lat = parseFloat(ubicacion.lat);
        this.lng = parseFloat(ubicacion.lon);
        this.latInput = this.lat;
        this.lngInput = this.lng;
        this.direccionSeleccionada = ubicacion.display_name;
        this.map.setView([this.lat, this.lng], 16);
        this.colocarMarcador(this.lat, this.lng);
      } else {
        alert('Dirección no encontrada dentro del departamento seleccionado');
        this.direccion = '';
        this.provinciaSeleccionada = '';
      }
    },

    procesarURL() {
      const coordenadas = this.extraerCoordenadasDesdeURL(this.url);
      if (!coordenadas) {
        alert('No se pudieron extraer coordenadas de la URL.');
        return;
      }
      const [lat, lng] = coordenadas;
      this.map.setView([lat, lng], 17);
      this.colocarMarcador(lat, lng);
      this.obtenerDireccion(lat, lng);
    },

    centrarPorCoordenadas() {
      if (!this.latInput || !this.lngInput) return;
      this.lat = parseFloat(this.latInput);
      this.lng = parseFloat(this.lngInput);
      this.map.setView([this.lat, this.lng], 16);
      this.colocarMarcador(this.lat, this.lng);
      this.obtenerDireccion(this.lat, this.lng);
    },

    imprimir() {
      window.print();
    },

    centrarEnDepartamento() {
      const limites = this.limitesDepartamentos[this.departamentoSeleccionado];
      if (!limites) return;

      const bounds = [
        [limites.minLat, limites.minLng],
        [limites.maxLat, limites.maxLng]
      ];
      this.map.fitBounds(bounds);

      if (this.boundaryRectangle) this.map.removeLayer(this.boundaryRectangle);
      this.boundaryRectangle = L.rectangle(bounds, {
        color: "#FF7800",
        weight: 1,
        fillOpacity: 0.1
      }).addTo(this.map);

      if (this.geojsonLayer) this.map.removeLayer(this.geojsonLayer);
      this.geojsonLayer = L.geoJSON(this.geojsonData, {
        filter: f => f.properties.shapeName === this.departamentoSeleccionado,
        style: {
          color: "#0066CC",
          weight: 2,
          fillOpacity: 0.05
        }
      }).addTo(this.map);
    },

    async cargarGeoJSON() {
      try {
        const response = await fetch('/geojson/geoBoundaries-BOL-ADM1.geojson');
        const geojson = await response.json();
        this.geojsonData = geojson;
        this.limitesDepartamentos = this.extraerLimitesDepartamentos(geojson);
        this.departamentoIdNombreMap = this.crearMapaIdNombre(geojson);
        L.geoJSON(geojson, {
          style: {
            color: "#999",
            weight: 1,
            fillOpacity: 0.05
          }
        }).addTo(this.map);
      } catch (error) {
        console.error('Error cargando GeoJSON:', error);
      }
    },

    crearMapaIdNombre(geojson) {
      const mapa = {};
      geojson.features.forEach(f => {
        if (f.properties && f.properties.id && f.properties.shapeName) {
          mapa[f.properties.id] = f.properties.shapeName;
        }
      });
      return mapa;
    },

    extraerLimitesDepartamentos(geojson) {
      const limites = {};
      geojson.features.forEach((feature) => {
        const nombre = feature.properties.shapeName;
        const coords = feature.geometry.coordinates;
        let puntos = [];
        if (feature.geometry.type === 'Polygon') {
          puntos = coords[0];
        } else if (feature.geometry.type === 'MultiPolygon') {
          coords.forEach(polygon => {
            puntos = puntos.concat(polygon[0]);
          });
        }
        const lats = puntos.map(p => p[1]);
        const lngs = puntos.map(p => p[0]);
        limites[nombre] = {
          minLat: Math.min(...lats),
          maxLat: Math.max(...lats),
          minLng: Math.min(...lngs),
          maxLng: Math.max(...lngs)
        };
      });
      return limites;
    },

    async cargarUbicaciones() {
      try {
        const response = await fetch('/geojson/bolivia.json');
        this.ubicaciones = await response.json();
      } catch (error) {
        console.error('Error cargando ubicaciones:', error);
      }
    },

    filtrarProvincias(dep) {
      if (!dep || !this.ubicaciones.length) {
        this.provinciasFiltradas = [];
        return;
      }

      const provincias = this.ubicaciones
        .filter(u => u.dep === this.address.city_address_id)
        .map(u => u.prov_mun);

      this.provinciasFiltradas = [...new Set(provincias)];
    },

    extraerCoordenadasDesdeURL(url) {
      const regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
      const match = url.match(regex);
      if (match) {
        return [parseFloat(match[1]), parseFloat(match[2])];
      }
      return null;
    },

    limpiarCampos() {
      this.provinciaSeleccionada = null;
      this.direccion = '';
    }
  }
};
</script>

<style>
#direccion-print {
  display: none;
}
@media print {
  body, body * {
    visibility: hidden !important;
  }
  #map, #map * {
    visibility: visible !important;
  }
  #map {
    position: absolute !important;
    top: 0;
    left: 0;
    width: 100vw !important;
    height: 90vh !important;
    z-index: 9999;
  }
  #direccion-print {
    display: block !important;
    position: absolute;
    bottom: 1.5cm;
    left: 1.5cm;
    font-size: 14pt;
    font-family: sans-serif;
    color: #000;
    visibility: visible !important;
    z-index: 9999;
  }
}
</style>
