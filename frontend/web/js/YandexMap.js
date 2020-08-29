/* jshint esversion: 6 */

(() => {

  /**
   * NOTE:
   * The ymaps.ready () function will be called when
   * all API components are loaded, as well as when the DOM tree is ready.
   */
  ymaps.ready(init);

  function init() {

    // NOTE: creating map
    const locationPosition = document.querySelector('[name="location-position"]');
    if (locationPosition) {
      const center = locationPosition.value.split(` `);
      const map = new ymaps.Map("map", {

        /**
         * NOTE:
         * Coordinates of the map center.
         * Default order: "latitude, longitude".
         * To avoid manually defining the coordinates of the map center,
         * use the coordinate Definition tool.
         */
        center,

        /**
         * NOTE:
         * Zoom level. Acceptable values:
         * from 0 (the whole world) to 19.
         */
        zoom: 13
      });

      map.geoObjects.add(new ymaps.Placemark(center, {
        balloonContent: '<strong>Метка цели</strong>'
      }, {
        preset: 'islands#redIcon',
      }));

    }
  }
})();
