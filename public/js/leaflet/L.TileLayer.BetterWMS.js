L.TileLayer.BetterWMS = L.TileLayer.WMS.extend({
  onAdd: function (map) {
    // Triggered when the layer is added to a map.
    //   Register a click listener, then do all the upstream WMS things
    L.TileLayer.WMS.prototype.onAdd.call(this, map)
    map.on("click", this.getFeatureInfo, this)
  },

  onRemove: function (map) {
    // Triggered when the layer is removed from a map.
    //   Unregister a click listener, then do all the upstream WMS things
    L.TileLayer.WMS.prototype.onRemove.call(this, map)
    map.off("click", this.getFeatureInfo, this)
  },

  getFeatureInfo: function (evt) {
    // Make an AJAX request to the server and hope for the best
    var url = this.getFeatureInfoUrl(evt.latlng),
      showResults = L.Util.bind(this.showGetFeatureInfo, this)
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        // console.log(data.features.length)
        if (data.features.length > 0) {
          var lot = data.features[0].properties.nlot
          var pa = data.features[0].properties.pa
          var luas = data.features[0].properties.m_area
          var lotdata = [lot, pa, luas]
          showResults(evt.latlng, lotdata)
        } else {
          showResults(evt.latlng, "")
        }
      })
  },

  getFeatureInfoUrl: function (latlng) {
    // Construct a GetFeatureInfo request URL given a point

    var point = this._map.latLngToContainerPoint(latlng, this._map.getZoom()),
      size = this._map.getSize()

    params = {
      request: "GetFeatureInfo",
      service: "WMS",
      srs: "EPSG:4326",
      styles: this.wmsParams.styles,
      transparent: this.wmsParams.transparent,
      version: this.wmsParams.version,
      format: this.wmsParams.format,
      bbox: this._map.getBounds().toBBoxString(),
      height: size.y,
      width: size.x,
      layers: this.wmsParams.layers,
      query_layers: this.wmsParams.layers,
      info_format: "application/json"
    }

    params[params.version === "1.3.0" ? "i" : "x"] = point.x
    params[params.version === "1.3.0" ? "j" : "y"] = point.y

    return this._url + L.Util.getParamString(params, this._url, true)
  },

  showGetFeatureInfo: function (latlng, lotdata) {
    var lot = lotdata[0]
    var pa = lotdata[1]
    var luas = lotdata[2]
    var lat = latlng.lat
    var lng = latlng.lng
    var properties = "<table class='table-info' style='font-size:12px; width:250px'>"
    properties += "<tbody>"
    properties += "<tr><td width='40%'><b>No.Lot : </b></td><td width='60%'>" + lot + "</td></tr>"
    properties += "<tr><td width='40%'><b>No.PA : </b></td><td width='60%'>" + pa + "</td></tr>"
    properties += "<tr><td width='40%'><b>Keluasan : </b></td><td width='60%'>" + luas + "</td></tr>"
    properties += "<tr><td width='40%'><b>Koordinat X : </b></td><td width='60%'>" + lat.toString().substr(0, 15) + "</td></tr>"
    properties += "<tr><td width='40%'><b>Koordinat Y : </b></td><td width='60%'>" + lng.toString().substr(0, 15) + "</td></tr>"
    properties += "<tr><td colspan='2'></td></tr>"
    properties += "<tr><td colspan='2' style='text-align:center; padding-top:10px;'>"
    properties += "<button id='copy' class='btn btn-success btn-xs' data-lot='" + lotdata[0] + "' data-pa='" + lotdata[1] + "' data-luasan='" + lotdata[2] + "'>Salinan</button>"
    properties += "</td></tr>"
    properties += "</tbody></table>"
    L.popup().setLatLng(latlng).setContent(properties).openOn(this._map)
  }
})

L.tileLayer.betterWms = function (url, options) {
  return new L.TileLayer.BetterWMS(url, options)
}
