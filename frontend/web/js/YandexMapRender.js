/* jshint esversion: 6 */

ymaps.ready(init);

function init() {
  var myMap = new ymaps.Map("map", {
    center: mapCenter,
    zoom: 12,
    controls: [
      'zoomControl',
      'rulerControl',
      'routeButtonControl',
      'trafficControl',
      'typeSelector',
      'fullscreenControl',

      new ymaps.control.SearchControl({
        options: {
          size: 'small',
          provider: 'yandex#search'
        }
      })

    ]
  });

  var myPlacemark = new ymaps.Placemark(mapCenter, {
    hintContent: 'Содержимое всплывающей подсказки',
    balloonContent: 'Содержимое балуна'
  });

  myMap.geoObjects.add(myPlacemark);
}
